<!-- 
Questo modulo permette di aprire una pagina personalizzata di dialogo con l'utente (alert o prompt).

Alert: Messaggio personalizzato con tasto ok
Prompt: Messaggio personalizzato, input, tasto ok e annulla

Richiamare alert: alert(messaggio);
Richiamare Prompt: custom_prompt();
Richiamare Dialog: dialog(messaggio);

-->

<!-- modal : start -->
<div id="modal" class="modal-container">
  <div class="modal">
    <p id="messaggio_alert"></p>
    <button id="gotit">OK</button>
  </div>
</div>
<!-- modal : end -->

<div id="prompt" class="prompt-container">
  <div class="prompt">
	  <p id="messaggio_prompt"></p>
    <input type="text" name="input" id="prompt-textbox" style=" border-color: #ececec !important; width:  100%; margin: 25px 0;    border-width: 1px !important;"><br>
    <button id="btn-ok">OK</button>
    <button id="btn-cancel">CANCEL</button>
  </div>
</div>


<div id="dialog" class="prompt-container">
  <div class="prompt">
	<p id="messaggio_dialog" ></p>
    <button id="dialog-ok">OK</button>
    <button id="dialog-cancel">CANCEL</button>
  </div>
</div>


<script>
$("#modal").hide();
$("#prompt").hide();
$("#dialog").hide();

(function() {
    window.alert = function(str) {
		custom_alert(str);
 	};
})();
	
function custom_alert(message){
  $("#messaggio_alert").html(message);
  $("#modal").show("closed");
}

function dialog(message){
  $("#messaggio_dialog").html(message);
  $("#dialog").show("closed");
	
	$("#dialog-cancel").on("click", function(){
	  $("#dialog").fadeOut();
	});
	$("#dialog-ok").on("click", function(){
	  $("#dialog").fadeOut();
	});
	
}

function prompt(message){
  $("#messaggio_prompt").html(message);
  $("#prompt").show("closed");
	
	$("#btn-cancel").on("click", function(){
	  $("#prompt").fadeOut();
	  $("#prompt-textbox").val("");
	});
	$("#btn-ok").on("click", function(){
	  $("#prompt").fadeOut();
	  $("#prompt-textbox").val("");
	});
	
}

$("button").on("click", function(){
  $("#modal").fadeOut();
});

$(".modal-container").on("click", function(){
  $("#modal").fadeOut();
});

$(".open-prompt").on("click", function(event){
  event.preventDefault();
  event.stopPropagation();
  $("#prompt").show("closed");
});

$("#btn-cancel").on("click", function(){
  $("#prompt").fadeOut();
});
$("#btn-ok").on("click", function(){
  $("#prompt").fadeOut();
});

//Da includere dove si ha il bisogno dell'event 

/*$(".prompt-container").on("click", function(){
  $("#prompt").fadeOut();
});*/
</script>

<style>

.modal-container:before, .prompt-container:before {
  content: "";
  background-color: rgba(0, 0, 0, 0.6);
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}
.modal-container:closed, .prompt-container:closed {
  display: none;
}

.modal, .prompt {
  position: fixed;
  top: 50px;
  left: 0px;
  right: 0px;
  margin: 0 auto;
  display: block;
  background: white;
  padding: 40px;
  width: 600px;
  max-width: 100%;
  z-index: 1;
}

</style>
