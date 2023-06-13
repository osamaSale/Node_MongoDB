const express = require("express");
const {
  getUserList,
  getIdUser,
  createUser,
  editUser,
  deleteUser,
  search,
  login
} = require("../controller/users");
const { upload } = require("../connection/upload");
const router = express.Router();
router.get("/users", getUserList);
router.get("/users/:id", getIdUser);
router.post("/users", upload.single("image"), createUser);
router.put("/users/:id", upload.single("image"), editUser);
router.delete("/users/:id", deleteUser);
router.get(`/search/:name`, search);
router.post(`/login`, login);
module.exports = router;
