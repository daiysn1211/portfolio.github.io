//パスワード表示設定
window.addEventListener('DOMContentLoaded',function(){
  let btn_passview = document.getElementById("btn_passview");
  let join_pass = document.getElementById("join_pass");
  btn_passview.addEventListener("click",(e)=>{

    e.preventDefault();

    if(join_pass.type === 'password'){
      join_pass.type='text';
      btn_passview.textContent = 'かくす';
    } else {
      join_pass.type='password';
      btn_passview.textContent = 'ひょうじ';
    }
  })
})



