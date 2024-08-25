const { AskQuery } = require('../controllers/auth-controller');
const express = require('express');
const router = express.Router();
const upload = require('../middleware/auth'); // Ensure this points to your multer setup

router.post('/AskQuery', upload.single('image'), AskQuery);

module.exports = router;
