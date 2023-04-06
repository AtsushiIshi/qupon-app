// ボタン要素の取得
const btn=document.getElementById("checkAll");
btn.onclick=checked;

// クリックすると関数が実行されてチェックが入る
function checked (){
  let boxes=document.querySelectorAll('input[type="checkbox"]');
  for(let i=0; i<boxes.length; i++){
    boxes[i].checked=true;
  }
  this.onclick=unChecked;
}

// もう一度クリックすると関数が実行されてチェックが外れる
function unChecked(){
  let boxes=document.querySelectorAll('input[type="checkbox"]');
  for(let i=0; i<boxes.length; i++){
    boxes[i].checked=false;
  }
  this.onclick=checked;
}




