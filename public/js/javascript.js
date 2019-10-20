
//Function Copy <content html> élemente
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  alert("Code Copy");
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}




// Function NavBar toggle //
function NavBarToggle(element){
  $(".wrapper").toggleClass("closeNav");
}