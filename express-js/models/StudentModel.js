let students = ["Mikel", "Hannah", "Jonas"];

const StudentModel = {
  getStudents: async () => {
    return new Promise((resolve, reject) => {
      if (students) {
        resolve(students);
      } else {
        reject("Data tidak ada!");
      }
    });
  },
  addStudent: async (name) => {
    return new Promise((resolve, reject) => {
      students.push(name);
      resolve(students);
    });
  },
  updateStudent: async (id, name) => {
    return new Promise((resolve, reject) => {
      if (id < 1 || id > students.length) {
        reject("Gagal mengubah data, data tidak terdaftar.");
      } else {
        students[id] = name;
        resolve(students);
      }
    });
  },
  deleteStudent: async (id) => {
    return new Promise((resolve, reject) => {
      if (id < 1 || id > students.length) {
        reject("Gagal menghapus data, data tidak terdaftar.");
      } else {
        students = students.filter((_, index) => index != id);
        resolve(students);
      }
    });
  },
};

module.exports = StudentModel;
