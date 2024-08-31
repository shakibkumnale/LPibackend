const corn=require('cors')
const express = require('express')
const app = express();
require('dotenv').config();
const multer = require("multer");
const UserModel=require('../models/users')
const otpGenerator = require('otp-generator');
const nodemailer = require("nodemailer");
const path= require('path')
const ejs = require('ejs');
app.use(corn())
const {
  GoogleGenerativeAI,
  HarmCategory,
  HarmBlockThreshold,
} = require("@google/generative-ai");
const { GoogleAIFileManager } = require("@google/generative-ai/server");
const { Schema } = require('mongoose');
const { verify } = require('crypto');
// const { GoogleAIFileManager } = require("@google/generative-ai/files");
const apiKey = process.env.API_KEY;
const fileManager = new GoogleAIFileManager(apiKey);
// const upload = multer({ dest: "uploads/" });
const genAI = new GoogleGenerativeAI(apiKey);
// const fileManager = new GoogleAIFileManager(apiKey);

const transporter = nodemailer.createTransport({
  service:'gmail',
   auth: {
     // TODO: replace `user` and `pass` values from <https://forwardemail.net>
     user: process.env.SENDER_EMAIL,
     pass: process.env.SECRETE_KEY,
   },
 });


let olddata= [
  {
    role: "user",
    parts: [
      {text: "hi\n"},
    ],
  },
 ]
 async function uploadToGemini(path, mimeType) {
  const uploadResult = await fileManager.uploadFile(path, {
    mimeType,
    displayName: path,
  });
  const file = uploadResult.file;
  console.log(`Uploaded file ${file.displayName} as: ${file.name}`);
  return file;
}
const model = genAI.getGenerativeModel({
  model: "gemini-1.5-flash",
  systemInstruction: "we started a campaign called label padega india in that we aware people to read every food packed which they purchase there is many companies  that misleading or not show actual ingredient of product in font or cover but they have to mention in so that they put in back back side but there is a problem companies write ingredients scientific name you are help user to understand the ingredient, tell user to it healthy or not and rate it between 0 to 10  ",
});
const generationConfig = {
  temperature: 1,
  topP: 0.95,
  topK: 64,
  maxOutputTokens: 8192,
  responseMimeType: "text/plain",
};


const AskQuery=async(req,res)=>{
    const safetySettings = [
    {
      category: HarmCategory.HARM_CATEGORY_HARASSMENT,
      threshold: HarmBlockThreshold.BLOCK_MEDIUM_AND_ABOVE,
    },
    {
      category: HarmCategory.HARM_CATEGORY_HATE_SPEECH,
      threshold: HarmBlockThreshold.BLOCK_MEDIUM_AND_ABOVE,
    },
    {
      category: HarmCategory.HARM_CATEGORY_SEXUALLY_EXPLICIT,
      threshold: HarmBlockThreshold.BLOCK_MEDIUM_AND_ABOVE,
    },
    {
      category: HarmCategory.HARM_CATEGORY_DANGEROUS_CONTENT,
      threshold: HarmBlockThreshold.BLOCK_MEDIUM_AND_ABOVE,
    },
  ];
  

try{
  console.log(req.body)
  const { text } = req.body;
  console.log(text);
  
  console.log(req.file!==null)
  console.log(req.file!==undefined)
  if (req.file!==undefined) {
  const { path, mimetype } = req.file;
  
  // Upload the image to Gemini
  const uploadedFile = await uploadToGemini(path, mimetype);
  olddata=[...olddata, {
    role: "user",
    parts: [
      {
        fileData: {
          mimeType: uploadedFile.mimeType,
          fileUri: uploadedFile.uri,
        },
      },
      {
        text: text,
      },
    ],
  }, ]
  // Start a chat session with the model
}
  const chatSession = model.startChat({
      generationConfig,
      safetySettings,
      history: olddata,
    
    });

    // Send a message to the chat session
    const result = await chatSession.sendMessage(text);
olddata=[...olddata, {
  role: "user",
  parts: [
    {text: text},
  ],
},
{
  role: "model",
  parts: [
    {text:result.response.text() },
  ],
},]
    // Send the response back to the client
    res.status(201).send( result.response.text(),)
    console.log(result.response.text());
    
  } catch (error) {
    console.error(error);
    res.status(500).send("An error occurred while processing your request.");
  }



}
const otps={}
const SignUp=async(req, res)=>{

  try {
     const {Fname,Phone,Email,City,Password,CPassword,Lname,}=req.body;
     if(Password!==CPassword){ return res.status(400).json({ message: 'Passwords do not match',  errorCode: 'PASSWORD_MISMATCH'  });}
    //  if(otps[Email]!==OTP){return res.status(400).json({ message: 'invalid otp',  errorCode: 'INVALID_OTP'  });}
     const User=new UserModel({
      Fname:Fname,
      Lname:Lname,
      Phone:Phone,
      City:City,
      Email:Email,
      Password:Password,

     })
     const created= await User.save();
     GenerateOtp(Email)
  res.send('djhsdhjs')
  } catch (error) {
    console.error(error); // Log the error for debugging purposes
    res.status(500).json({ 
        message: 'Internal error', 
        errorCode: 'INTERNAL_ERROR',
        error: error.message // Send the error message
    });
    
  }
}

const reSendOtp=async(req,res)=>{
  try {
    const {Email}=req.body
    if(!Email){return res.status(400).json({ message: 'Email required',  errorCode: 'EMAIL_REQUIRED'  });}
    const user= await UserModel.findOne({Email:Email})
    if(!user){return res.status(400).json({ message: 'user not found',  errorCode: 'USER_NOT_FOUND'  });}
    console.log(user.Verified)
 if(user.Verified){return res.status(400).json({ message: 'already verified',  errorCode: 'ALREADY_VERIFIED'  });}

    GenerateOtp(Email)
    res.status(201).json({message:"success"})

  } catch (error) {
    console.error(error); // Log the error for debugging purposes
    res.status(500).json({ 
        message: 'Internal error', 
        errorCode: 'INTERNAL_ERROR',
        error: error.message // Send the error message
    });
    
  }
}

const GenerateOtp=async(email)=>{
  try {
  
    if(!email){return res.status(400).json({ message: 'Email required',  errorCode: 'EMAIL_NOT_FOUNDED'  });}
    const otp = otpGenerator.generate(6, { 
      upperCaseAlphabets: false, 
      specialChars: false,
      lowerCaseAlphabets:false
    });
    otps[email]=otp
    console.log(otp);
;
  // 
  const fdate = formatDate(Date.now());
  ejs.renderFile(path.join(__dirname, '../Template/emailTemplate.ejs'), { otp, email,fdate }, (err, data) => {
      if (err) {
        console.log(err);
        
       throw err;
      } else {
          const options = {
              from: '"Lpi" <stkbantai1@gmail.com>',
              to: email,
              subject: 'Your OTP Code',
              attachments: [{
                  // filename: 'LPi.jpg',
                  path: path.join(__dirname, '../uploads/LPilogo.png'),
                  cid: 'myImg' // Same cid value as in the template
              }],
              html: data,
          };

          transporter.sendMail(options, (error, info) => {
              if (error) {
                console.log(error);
                throw error;
              }
              console.log('Message sent: %s', info.messageId);
          });
      }
  }); 


    

  } catch (error) {
console.log(error);
                throw error;
    
  }

}
const otpVerify=async(req,res)=>{
  try {
    const {otp}=req.body 
    const email=req.body.Email

    if (otps[email]===otp) {
      await UserModel.updateOne({Email:email}, { Verified:true});
      otps[email]="";
      res.status(201).json({message:"success"})
      
    }else{
     res.status(400).json({ message: 'invalid otp',  errorCode: 'INVALID_OTP'  });

    }
  } catch (error) {
    console.error(error); // Log the error for debugging purposes
    res.status(500).json({ 
        message: 'Internal error', 
        errorCode: 'INTERNAL_ERROR',
        error: error.message // Send the error message
    });
  }

}


function formatDate(timestamp) {
  const date = new Date(timestamp);

  const day = date.getDate();
  const month = date.toLocaleString('default', { month: 'short' });
  const year = date.getFullYear();

  return `${day} ${month}, ${year}`;
}
const sendEmail = (otp, email) => {
};
module.exports={AskQuery, SignUp, otpVerify, reSendOtp}