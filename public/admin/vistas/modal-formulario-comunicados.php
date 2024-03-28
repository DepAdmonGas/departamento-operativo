 <div class="modal-header">
<h5 class="modal-title">Agregar comunicado</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>


<div class="modal-body">
	
<div class="row">

<div class="col-12 mb-2"> 
<div class="mb-1 text-secondary">Fecha:</div>
<input type="date" class="form-control rounded-0" id="fechaComunicado">  
</div>

<div class="col-12 mb-2"> 
<div class="mb-1 text-secondary">Titulo:</div>
<input type="text" class="form-control rounded-0" id="tituloComunicado">  
</div>

<div class="col-12"> 
<div class="mb-1 text-secondary">Documento:</div>
<input class="form-control" type="file" id="ArchivoComunicado">
</div>

</div>

</div>
    
  
  <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-success" onclick="DocumentoComunicado()">Agregar</button>
  </div> 