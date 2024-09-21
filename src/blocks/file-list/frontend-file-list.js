import { Modal } from "flowbite";

function print(content) {
  // Makes the content in the div tag
  // as the main and only content
  // and assigns to this variable
  var printContent = document.getElementById(content).innerHTML;

  // Complete content of the page
  var originalContent = document.body.innerHTML;

  // printContents is assigned to innerHtml now
  // the printable content is the div tag
  document.body.innerHTML = printContent;

  window.print(); // Prints the page

  // originalContent is assigned to innerHtml
  // now the printable content is the complete
  // displayed page
  document.body.innerHTML = originalContent;
}
