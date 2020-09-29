<div id="files" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">

    <form enctype="multipart/form-data" action="addPhotoInOperations.php" id="uploads" name="uploads" method="POST" >
        <input type="hidden" id="ACTION" name="ACTION" value="LOAD_TO_OPERATIONS" />
        <input type="hidden" id="txt_delivery" name="txt_delivery" values="" />


        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Selecione os Arquivos.</h5>
            <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <input type="file" id="files" name="file[]" multiple />
        </div>
        
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">Close</button>
        </div>
        </div>
    </form>


  </div>
</div>

<script>

$(document).ready(function(){

    $("#uploads").submit(function(event){
        var formData = new FormData($("#uploads").get(0));
		var ajaxUrl = "addPhotoInOperations.php";
         console.log(formData)
     //    alert("")

       // event.preventDefault();
    });


    $(".closeModal").on("click",function(){
        
        $("#files").hide();
    
    })
   
});


   
</script>
