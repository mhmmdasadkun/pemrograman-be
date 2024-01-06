const express = require("express");
const routes = express.Router();

// Controllers
const StudentController = require("../controllers/StudentController");

routes.get("/", (req, res) => {
  res.send("Hello Express");
});

routes.get("/students", StudentController.index);
routes.get("/students/:id", StudentController.find);
routes.post("/students", StudentController.store);
routes.put("/students/:id", StudentController.update);
routes.delete("/students/:id", StudentController.delete);


module.exports = routes;