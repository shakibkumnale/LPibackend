const express = require('express')
require('dotenv').config();
const app = express();
const corn=require('cors')

app.use(express.json());
app.use(express.urlencoded({extended:false}))
app.use(corn())
const port =  process.env.PORT||3005 

const router =require('./router/auth-router')
app.use('/',router)

app.listen(port, () => console.log(`Example app listening on port ${port}!`))