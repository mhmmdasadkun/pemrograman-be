const express = require("express");
const router = require("./routes/api");

const app = express();

app.use(express.json());
app.use(express.urlencoded({ extended: true })); // Corrected usage
app.use(router);

// Start the server
app.listen(3000);
