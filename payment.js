// 要素の取得
let before=document.getElementById('amount_before');  
let after=document.getElementById('amount_after');
let discount_rate=document.getElementById('discount_rate');
let receivedAmount=document.getElementById('received_amount');
let change=document.getElementById('change');


function calcAmount(){                     
  discount.innerText=before.value*discount_rate.value * 0.01;
  after.innerText=before.value-discount.innerText;
}

before.addEventListener('keydown',calcAmount);



  function calcChange(){
  change.innerText=receivedAmount.value-after.textContent;
}

receivedAmount.addEventListener('keyup',calcChange);


