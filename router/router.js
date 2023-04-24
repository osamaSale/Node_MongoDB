const express = require("express");
const { getUserList, getIdUser, createUser } = require("../controller/users")
const { upload } = require("../connection/upload")
const router = express.Router();
router.get("/users", getUserList)
router.get("/users/:id", getIdUser)
router.post("/users",upload.single("fileImage") , createUser)
module.exports = router;