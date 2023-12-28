const express = require("express");
const routes = express.Router();

// Controllers
const StudentController = require("../controllers/StudentController");

routes.get("/", (req, res) => {
  res.send("Hello Express");
});

routes.get("/students", StudentController.index);
routes.post("/students", StudentController.store);

module.exports = routes;