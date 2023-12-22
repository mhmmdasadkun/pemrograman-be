const StudentModel = require("../models/StudentModel");

const StudentController = {
  index: async (req, res) => {
    try {
      const students = await StudentModel.getStudents();
      res.status(200).json({
        message: "Menampilkan semua students",
        data: students,
      });
    } catch (error) {
      res.status(400).json({ message: error });
      res.end();
    }
  },
  store: async (req, res) => {
    try {
      const { name } = req.body;
      const students = await StudentModel.addStudent(name);
      res.status(201).json({
        message: `Menambahkan data student: ${name}`,
        data: students,
      });
    } catch (error) {
      res.status(400).json({ message: "Gagal menambahkan data." });
      res.end();
    }
  },
  update: async (req, res) => {
    try {
      const { id } = req.params;
      const { name } = req.body;
      const students = await StudentModel.updateStudent(id, name);
      res.status(200).json({
        message: `Mengubah student id/index ${id}, nama ${name}`,
        data: students,
      });
    } catch (error) {
      res.status(400).json({ message: error });
      res.end();
    }
  },
  destroy: async (req, res) => {
    try {
      const { id } = req.params;
      const students = await StudentModel.deleteStudent(id);
      res.status(200).json({
        message: `Menghapus student id/index ${id}`,
        data: students,
      });
    } catch (error) {
      res.status(400).json({ message: error });
      res.end();
    }
  },
};

module.exports = StudentController;
