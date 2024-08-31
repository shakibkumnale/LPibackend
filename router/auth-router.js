const { AskQuery,SignUp,otpVerify,reSendOtp } = require('../controllers/auth-controller');
const express = require('express');
const router = express.Router();
const upload = require('../middleware/uploads'); // Ensure this points to your multer setup

router.post('/AskQuery', upload.single('image'), AskQuery);
router.post('/SignUp',SignUp )
router.post('/GenerateOtp',otpVerify )
router.post('/reSendOtp',reSendOtp)


module.exports = router;
