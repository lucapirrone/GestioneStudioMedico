<?php if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit(); ?>
<link rel="stylesheet" type="text/css" href="../css/tabs_seleziona_emittente_fattura.css">
	   <h2 class="title testo-grande">Seleziona Destinatario Fattura</h2>

	<main>
  
  <input id="tab2" type="radio" name="tabs" checked>
  <label for="tab2">Paziente</label>
    
  <input id="tab3" type="radio" name="tabs">
  <label for="tab3">Medico</label>
    
  <input id="tab4" type="radio" name="tabs">
  <label for="tab4">Società</label>
    
  <section id="content2">
    <?php include 'seleziona_paziente.php'; ?>
  </section>
    
  <section id="content3">
    <?php include 'seleziona_medico.php'; ?>
  </section>
    
  <section id="content4">
    <?php include 'seleziona_societa.php'; ?>
  </section>
    
</main>