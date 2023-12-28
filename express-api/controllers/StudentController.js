const Student = require("../models/Student");

const StudentController = {
  index: async (req, res) => {
    try {
      const students = await Student.findAll();
      res.status(200).json({
        message: "Menampilkan semua students",
        data: students,
      });
    } catch (error) {
      res.status(500).json({ message: "Internal Server Error" });
      res.end();
    }
  },
  store: async (req, res) => {
    try {
      const { nama, nim, email, jurusan } = req.body;

      const students = await Student.create({ nama, nim, email, jurusan });
      res.status(201).json({
        message: "Data berhasil ditambahkan",
        data: students,
      });
    } catch (error) {
      res.status(400).json({ message: "Gagal menambahkan data." });
      res.end();
    }
  },
};

module.exports = StudentController;
