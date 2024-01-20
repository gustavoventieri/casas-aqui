let menu = document.querySelector('.header .menu');

document.querySelector('#menu-btn').onclick = () =>{
   menu.classList.toggle('active');
}

window.onscroll = () =>{
   menu.classList.remove('active');
}

document.querySelectorAll('input[type="number"]').forEach(inputNumber => {
   inputNumber.oninput = () =>{
      if(inputNumber.value.length > inputNumber.maxLength) inputNumber.value = inputNumber.value.slice(0, inputNumber.maxLength);
   };
});

function MascaraTel(keypress) {
 if(keypress>=48 && keypress<=57) { 
   prefixo = '+'
   separadorl = ' ('; 
   separador2 = ') '; 
   separador3 = '-';
   conjuntol = 2;
   conjunto2 = 7;
   conjunto3 = 14;
   if (eval(document.registro.number.value.length) == conjuntol) {
      document.registro.number.value =  prefixo + document.registro.number.value  + separadorl; 
      }
   if (eval (document.registro.number.value.length) == conjunto2){
      document.registro.number.value = document.registro.number.value + separador2;  
   }
   if (eval (document.registro.number.value.length) == conjunto3){
      document.registro.number.value = document.registro.number.value + separador3; 
   } 
   return true;
} 
   else {
       return false;
   }
}

function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){  
   var sep = 0;  
   var key = '';  
   var i = j = 0;  
   var len = len2 = 0;  
   var strCheck = '0123456789';  
   var aux = aux2 = '';  
   var whichCode = (window.Event) ? e.which : e.keyCode;  
   if (whichCode == 13 || whichCode == 8) return true;  
   key = String.fromCharCode(whichCode); // Valor para o código da Chave  
   if (strCheck.indexOf(key) == -1) return false; // Chave inválida  
   len = objTextBox.value.length;  
   for(i = 0; i < len; i++)  
       if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;  
   aux = '';  
   for(; i < len; i++)  
       if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);  
   aux += key;  
   len = aux.length;  
   if (len == 0) objTextBox.value = '';  
   if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;  
   if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;  
   if (len > 2) {  
       aux2 = '';  
       for (j = 0, i = len - 3; i >= 0; i--) {  
           if (j == 3) {  
               aux2 += SeparadorMilesimo;  
               j = 0;  
           }  
           aux2 += aux.charAt(i);  
           j++;  
       }  
       objTextBox.value = '';  
       len2 = aux2.length;  
       for (i = len2 - 1; i >= 0; i--)  
       objTextBox.value += aux2.charAt(i);  
       objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);  
   }  
   return false;  
}  
