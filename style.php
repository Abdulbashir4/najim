*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* loging form css start here */
    .body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
#l_form {
    background-color: #d6d5d5;
    padding: 20px;
    height: 300px;
    width: 300px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    gap: 20px;
    margin-top: 0;
    padding-top: 0px;
}
.gb_title {
font-size: 25px;
color: black;
text-align: center;
}
#l_form input {
        margin-top: 0px;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid black;
    }
    #l_form button {
    padding: 10px 20px;
    border-radius: 50px;
    border: 1px solid black;
}

/* loging form css end here */


/* header & Drawer start here */
.for_body {
      flex: 1;
      display: flex;
    }

    .for_sidebar {
      width: 200px;
      background: #f4f4f4;
      padding: 10px;
      border-right: 1px solid #ddd;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .for_sidebar button {
      padding: 8px;
      border: none;
      background: #3498db;
      color: white;
      border-radius: 6px;
      cursor: pointer;
      text-align: left;
    }

    .for_content {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
    }








.header{
height: 70px;
width: 100%;
background-color: rgb(16, 173, 212);
display: flex;
justify-content: space-between;
flex-direction: row;
padding: 10px 60px;
position: sticky;
top: 0;
z-index: 2;
}
.menu{
  width: 30px;
  height: 25px;
  display: none;
  flex-direction: column;
  justify-content: space-between;
  cursor: pointer;
}
.menu span{
  display: block;
  height: 4px;
  background-color: #333;

}
.title{
    width: 80%;
    display: flex;
    align-items: center;
    color: aliceblue;

}

.drawer{
    width: 300px;
    background-color: beige;
    display: flex;
    flex-direction: column;
    padding: 20px;
    position: fixed;
    z-index: 1;

    top: 50px;
}
.drawer hr{
    border: 1px solid rgb(167, 162, 162);
    margin-top: 10px;
}
.dr_btn{
    width: 250px;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid rgb(161, 161, 161);
    font-size: 20px;
    text-decoration: none;
    

}
.account{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
.account img{
    width: 70px;

}

.button{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    padding: 20px;

}


/* header & Drawer end here */



.cls4{
    /* padding: 8px 15px;
    width: 100%;
    border-radius: 5px; */
    width: 100%;              /* পুরো চওড়া */
    max-width: 400px;         /* মোবাইলে সুন্দরভাবে বসবে */
    padding: 8px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
    background: #fff;
    cursor: pointer;
}
.cls4 option {
    padding: 8px;
}




















































@media (max-width: 600px){

/* Global Css Start here */
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.gb_title{
    font-size: 25px;
    color: black;
    text-align: center;

}
.gb_description{

}
.gb_btn{
        margin-top: 10px;
        font-size: 18px;
        padding: 10px 30px;
        cursor: pointer;
        border-radius: 5px;
        border: 1px solid black;
}
.page{
    
    width: 100%;
    justify-content: center;
    display: none;
    
}

.alart{
        position: absolute;
        top: 72%;
        left: 15%;
        color: red;
        font-weight: 900;
        font-size: 30px;
        background: #a4a4a4;
        padding: 10px 20px;
        border-radius: 10px;
}
/* Global Css end here */

/* header & Drawer start here */


.header{
height: 50px;
width: 100%;
background-color: rgb(16, 173, 212);
display: flex;
justify-content: space-between;
flex-direction: row;
padding: 10px 30px;
position: sticky;
top: 0;
z-index: 2;
}
.menu{
  width: 30px;
  height: 25px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  cursor: pointer;
}
.menu span{
  display: block;
  height: 4px;
  background-color: #333;

}
.title{
    width: 80%;
    display: flex;
    align-items: center;
    color: aliceblue;

}

.drawer{
    width: 300px;
    background-color: beige;
    display: none;
    flex-direction: column;
    padding: 20px;
    position: absolute;
    z-index: 1;
    top: 50px;
}
.drawer hr{
    border: 1px solid rgb(167, 162, 162);
    margin-top: 10px;
}
.dr_btn{
    width: 250px;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid rgb(161, 161, 161);
    font-size: 20px;
    text-decoration: none;
    

}
.account{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
.account img{
    width: 70px;

}

.button{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    padding: 20px;

}


/* header & Drawer end here */


/* Loging page start here */

#l_form{
    background-color: #d6d5d5;
    padding: 20px;
    height: 300px;
    width: 300px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    gap: 20px;
    margin-top: 0;
    padding-top: 0px;

}
#l_form input{
    margin-top: 0px;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid black;
}

#l_form button{
    padding: 10px 20px;
    border-radius: 50px;
    border: 1px solid black;
}

/* Loging page start here */








/* index page start here */
.body{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
/* index page end here */

/* registation page start here */
#r_form {
    background-color: #d6d5d5;
    padding: 20px;
    height: 300px;
    width: 300px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    margin-top: 0;
    padding-top: 0px;

}
#r_form input{
    margin-bottom: -20px;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid black;
}

#r_form button{
    padding: 10px 20px;
    border-radius: 50px;
    border: 1px solid black;
}
.selec{
    margin-top: 0px;
    padding: 10px 20px;
    width: 190px;
    border-radius: 4px;
    border: 1px solid rgb(0, 0, 0);
}
    .title1 {
        margin-bottom: 15px;
    }
/* registation page end here */



/* Admin page start here */


#home_page{
    display: flex;
    justify-content: center;
    align-items: center;
}


/* Admin page end here */

/* ADD customer page start here */
.cls1{
    font-size: 30px;
    background: #87a52a9e;
    padding: 10px;
    border-radius: 10px;
    margin: 10px;
    text-align: center;
}
.cls2{
    font-size: 20px;
    display: block;
    padding: 3px;
}
.cls3{
    padding: 10px;
    border-radius: 5px;
    border: 1px solid black;
    width: 100%;
}
.cls4{
    /* padding: 8px 15px;
    width: 100%;
    border-radius: 5px; */
   
}

.cls4 {
        font-size: 16px;
        max-height: 200px;   /* সীমা */
        overflow-y: auto;    /* স্ক্রল চালু */
    }
.cls5{
    width: 250px;
    min-height: 100px;
}
.cls6{
    background-color: black;
}
.cls6 img{
    opacity: 0.3;
    min-height: 100vh;
    width: 100%;
}
.cls6 p{
    color: rgb(255, 255, 255);
    position: absolute;
    font-size: 22px;
}
.custom-select {
      width: 250px;
      padding: 8px;
      font-size: 16px;
      border: 2px solid #4CAF50;
      border-radius: 8px;
      background: #fff;
      outline: none;
      height: 180px;         /* লিস্টবক্সের উচ্চতা */
      overflow-y: auto;      /* স্ক্রল আসবে */
    }

    /* অপশনগুলো স্টাইল */
    .custom-select option {
      padding: 6px;
      font-size: 14px;
    }

    /* স্ক্রলবার কাস্টমাইজ */
    .custom-select::-webkit-scrollbar {
      width: 8px;
    }
    .custom-select::-webkit-scrollbar-thumb {
      background: #4CAF50;
      border-radius: 10px;
    }
    .custom-select::-webkit-scrollbar-track {
      background: #ddd;
    }
/* ADD customer page end here */


.gb_btn{
        margin-top: 10px;
        font-size: 18px;
        padding: 10px 30px;
        cursor: pointer;
        border-radius: 5px;
        border: 1px solid black;
}






























}