const multer = require("multer");
const path = require('path')
require("dotenv").config();
const storage = multer.diskStorage({
  filename: function (req, file, cb) {
    cb(null, Date.now() + path.extname(file.originalname))
  }
})

const upload = multer({ storage: storage })

module.exports = { upload  };