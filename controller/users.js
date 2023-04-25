const User = require("../model/users");
const cloudinary = require("../connection/cloudinary");
const bcrypt = require("bcryptjs");
const fs = require("fs");
const jwt = require("jsonwebtoken");

// Error
const error422 = (massage) => {
  let data = {
    status: 422,
    massage: massage,
  };
  return data;
};

// Get All Users
const getUserList = (req, res) => {
  User.find().then((result) => {
    if (result.length === 0) {
      let data = { status: 202, massage: "No Users Found" };
      res.json(data);
    } else {
      let data = {
        status: 200,
        massage: "Users List Fetched Successfully",
        result: result,
      };
      res.json(data);
    }
  });
};

// Get ID User
const getIdUser = async (req, res) => {
  const id = req.params.id;
  User.findById(id)
    .then((result) => {
      res.json({
        massage: "successfully Create user",
        status: 200,
        result: result,
      });
    })
    .catch((err) => {
      res.json({ status: 202, massage: "No Users Found" });
    });
};

// create user

const createUser = async (req, res) => {
  let name = req.body.name;
  let email = req.body.email;
  let password = req.body.password;
  let phone = req.body.phone;
  let authorization = req.body.authorization;
  let fileImage = req.file;
  let cloudinary_id,
    image = null;
  if (name === "") {
    res.json(error422("Enter your name"));
  } else if (email === "") {
    res.json(error422("Enter your Email"));
  } else if (password === "") {
    res.json(error422("Enter your Password"));
  } else if (phone === "") {
    res.json(error422("Enter your Phone"));
  } else if (authorization === "") {
    res.json(error422("Enter your Authorization"));
  } else if (!fileImage) {
    res.json(error422("Enter your Image"));
  } else {
    if (fileImage) {
      fileImage = await cloudinary.uploader.upload(req.file.path);
      cloudinary_id = fileImage?.public_id;
      image = fileImage?.secure_url;
      fileImage = fileImage?.original_filename + "." + fileImage?.format;
    }
    password = bcrypt.hashSync(password, Number("salt"));
    let user = new User({
      name: name,
      email: email,
      password: password,
      phone: phone,
      image: image,
      fileImage: fileImage,
      cloudinary_id: cloudinary_id,
      authorization: authorization,
    });
    user
      .save()
      .then((result) => {
        if (result) {
          res.json({
            massage: "successfully Create user",
            status: 200,
            result: user,
          });
        }
      })
      .catch(async (err) => {
        if (err) {
          let deleteImage = await cloudinary.uploader.destroy(cloudinary_id);
          let deleteFile = await fs.unlink(`./images/${fileImage}`, (err) => {
            if (err) {
              return "error";
            } else {
              return "Ok";
            }
          });
          res.json({
            status: 201,
            massage: `You have entered invalid email ${user.email}`,
            deleteImage: deleteImage,
            deleteFile: deleteFile,
          });
        }
      });
  }
};

// edit User

const editUser = async (req, res) => {
  const id = req.params.id;
  let fileImage = req.file;
  let cloudinary_id,
    image = null;
  User.findById(id)
    .then(async (result) => {
      if (result) {
        if (fileImage) {
          await fs.unlink(`./images/${result.fileImage}`, (err) => {
            if (err) {
              return "error";
            } else {
              return "Ok";
            }
          });
          await cloudinary.uploader.destroy(result.cloudinary_id);
          fileImage = await cloudinary.uploader.upload(req.file.path);
          cloudinary_id = fileImage?.public_id;
          image = fileImage?.secure_url;
          fileImage = fileImage?.original_filename + "." + fileImage?.format;
        } else {
          cloudinary_id = result?.cloudinary_id;
          image = result?.image;
          fileImage = result?.fileImage;
        }
   
        let user = {
          name: req.body.name || result.name,
          email: req.body.email || result.email,
          password: req.body.password || result.password,
          phone: req.body.phone || result.phone,
          image: image || result.image,
          fileImage: fileImage || result.fileImage,
          cloudinary_id: cloudinary_id || result.cloudinary_id,
          authorization: req.body.authorization || result.authorization,
        };
        user.password = bcrypt.hashSync(user.password, Number("salt"));
        User.findByIdAndUpdate(id, { $set: user })
          .then((result) => {
            res.json({
              massage: "successfully Edit",
              status: 200,
              result: result,
            });
          })
          .catch((err) => {
            res.json({ err: " You have entered invalid  Email" ,status: 201});
          });
      } 
    })

    .catch(async (err) => {
      res.json({ status: 202, massage: "No Users Found" });
    });
};

// Delete User

const deleteUser = (req, res) => {
  const id = req.params.id;
  User.findById(id)
    .then(async (result) => {
      if (result) {
        let deleteImage = await cloudinary.uploader.destroy(
          result.cloudinary_id
        );
        let deleteFile = await fs.unlink(
          `./images/${result.fileImage}`,
          (err) => {
            if (err) {
              return "error";
            } else {
              return "Ok";
            }
          }
        );
        User.findByIdAndRemove(id).then((result) => {
          res.json({
            massage: "successfully Delete",
            status: 200,
            deleteImage: deleteImage,
            deleteFile: deleteFile,
          });
        });
      }
    })
    .catch(async () => {
      res.json({ status: 202, massage: "No Users Found" });
    });
};

// search  name

const search = async (req, res) => {
  const name = req.params.name;
  await User.find({ name })
    .then((result) => {
      res.json({
        massage: "successfully Edit",
        status: 200,
        result: result,
      });
    })
    .catch(async () => {
      res.json({ status: 202, massage: "No Users Found" });
    });
};

// Login

const login = async (req, res) => {
  try {
    let email = req.body.email;
    let password = req.body.password;
    let user = await User.findOne({ email });
    if (user) {
      if (await bcrypt.compare(password, user.password)) {
        let id = user.id;
        const token = jwt.sign({ id }, "jwtSecret", {
          expiresIn: process.env.TOKEN_EXPIRATION,
        });
        res.json({
          status: 200,
          massage: "successfully Login",
          result: user,
          token: token,
        });
      } else {
        res.json({ massage: "You have entered invalid Password", status: 201 });
      }
    } else {
      res.json({ massage: "You have entered invalid Email", status: 203 });
    }
  } catch (error) {
    console.log(error);
    res.status(500).send("Internal Server error Occured");
  }
};

module.exports = {
  getUserList,
  getIdUser,
  createUser,
  editUser,
  deleteUser,
  search,
  login,
};
