/**
 * Fungsi untuk menampilkan hasil download
 * @param {string} result - Nama file yang di download
 */

function showDownload(result) {
  console.log("Download Selesai");
  console.log("Hasil Download: " + result);
}

/**
 * Fungsi untuk download file
 * @returns {Promise<string>} - Promise yang akan diselesaikan dengan nama file yang di-download
 */
function download() {
  return new Promise((resolve) => {
    setTimeout(() => {
      const result = "windows-10.exe";
      resolve(result);
    }, 3000);
  });
}

// Contoh Promise.then untuk menangani hasil download
download().then((result) => {
  showDownload(result + " (Promise)");
});

// Contoh menggunakan async/await
async function runDownload() {
  const result = await download();
  showDownload(result + " (Async Await)");
}

runDownload();
