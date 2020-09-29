
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<form action="process" method="post"> 
  <input type="hidden" id="ACTION" name="ACTION" value="PROCESS_DATA_OPERATIONS" />
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Relatorio Gerencial</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        
          <div class="form-check">
          <input class="form-check-input" checked type="radio" value="1" name="rdb_op[]" >
          <label class="form-check-label" for="defaultCheck1">
              Dia Anterior (Default) 
          </label>
          </div>
          <div class="form-check">
          <input class="form-check-input" type="radio" value="2"  name="rdb_op[]"  >
          <label class="form-check-label" for="defaultCheck2">
              Por Data
          </label>

          <div class="form-group">
              <input type="text" id="datepicker" name="datepicker" class="form-control"  placeholder="Disabled input">
          </div>

          </div>


          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Continuar >></button>
        </div>
      </div>
    </div>
  </div>
</form>
<script>

$(document).ready(function(){
    $("#btn_selection").on("click",function(){
        $('#exampleModal').modal()
    });

    $("#datepicker").datepicker(
      {
          dateFormat: 'dd/mm/yy',
          changeMonth: true,
          changeYear: true
      }
    );


    


});


   
</script>