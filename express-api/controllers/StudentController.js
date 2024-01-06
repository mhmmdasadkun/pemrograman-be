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
  update: async (req, res) => {
    try {
      const studentId = req.params.id;
      const { nama, nim, email, jurusan } = req.body;

      const updatedStudent = await Student.update(
        { nama, nim, email, jurusan },
        { where: { id: studentId } }
      );

      const student = await Student.findByPk(studentId);


      res.status(200).json({
        message: "Data berhasil diperbarui",
        data: student,
      });
    } catch (error) {
      res.status(400).json({ message: "Gagal memperbarui data." });
      res.end();
    }
  },
  
  find: async (req, res) => {
    try {
      const studentId = req.params.id;
      const student = await Student.findByPk(studentId);

      if (!student) {
        return res.status(404).json({ message: "Data tidak ditemukan." });
      }

      res.status(200).json({
        message: "Menampilkan data student",
        data: student,
      });
    } catch (error) {
      res.status(500).json({ message: "Internal Server Error" });
      res.end();
    }
  },
  
  delete: async (req, res) => {
    try {
      const studentId = req.params.id;
      const deletedStudent = await Student.destroy({ where: { id: studentId } });

      if (!deletedStudent) {
        return res.status(404).json({ message: "Data tidak ditemukan." });
      }

      res.status(200).json({
        message: "Data berhasil dihapus",
        data: deletedStudent,
      });
    } catch (error) {
      res.status(500).json({ message: "Internal Server Error" });
      res.end();
    }
  },
};

module.exports = StudentController;
