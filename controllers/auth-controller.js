const corn=require('cors')
const express = require('express')
const app = express();
require('dotenv').config();
const multer = require("multer");
app.use(corn())
const {
  GoogleGenerativeAI,
  HarmCategory,
  HarmBlockThreshold,
} = require("@google/generative-ai");
const { GoogleAIFileManager } = require("@google/generative-ai/server")
// const { GoogleAIFileManager } = require("@google/generative-ai/files");
const apiKey = process.env.API_KEY;
const fileManager = new GoogleAIFileManager(apiKey);
// const upload = multer({ dest: "uploads/" });
const genAI = new GoogleGenerativeAI(apiKey);
// const fileManager = new GoogleAIFileManager(apiKey);
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
    res.send( result.response.text(),)
    console.log(result.response.text());
    
  } catch (error) {
    console.error(error);
    res.status(500).send("An error occurred while processing your request.");
  }



}
module.exports={AskQuery}