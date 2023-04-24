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
const getIdUser = (req, res) => {
  const id = req.param.id;
  if (id === null) {
    res.json(error422("Enter your name"));
  } else {
    User.findById({id:id}).then((result) => {
      if (result === null) {
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
  }
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
      cloudinary_id = fileImage?.original_filename;
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
          const options = {
            use_filename: true,
            unique_filename: false,
            overwrite: true,
          };
          let deleteImage = await cloudinary.uploader.destroy(
            fileImage,
            options
          );
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

module.exports = { getUserList, getIdUser, createUser };
