const express = require("express");
const cors = require("cors");
const mongodb = require("./connection/mongodb");
const router = require("./router/router");
const app = express();
require("dotenv").config();

const PORT = process.env.PORT || 5000;

const corsOptions = {
  origin: "*",
  optionsSuccessStatus: 200,
};
app.use(express.json());
app.use(cors(corsOptions));
app.use(router);

app.listen(PORT, () => {
  console.log(`http://localhost:${PORT}`);
});
