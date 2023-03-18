<!DOCTYPE html>
<html>
 <head>
  <title>Laravel CRUD with Ajax</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
 
 </head>
 <body>
  <br />
  <div class="container box">
   <h3 align="center">Laravel CRUD with Ajax</h3><br />
   <div class="panel panel-default">
    <div class="panel-heading">Products Lists</div>
    <div class="panel-body">
     <div id="message"></div>
     <div class="table-responsive">
      <table class="table table-striped table-bordered">
       <thead>
        <tr>
        <th data-id="productID">ID</th>
         <th>Name</th>
         <th>Description</th>
         <th>Price</th>
         <th>Delete</th>
        </tr>
       </thead>
       <tbody>
       
       </tbody>
      </table>
      {{ csrf_field() }}
     </div>
    </div>
   </div>
  </div>
 </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>

    /**Get All products */
getAllProducts();

function getAllProducts()
{
 $.ajax({
  url:"/product/lists/show",
  dataType:"json",
  success:function(data)
  {
   var products = '';
   products += '<tr>';
   products += '<td contenteditable id="name"></td>';
   products += '<td contenteditable id="description"></td>';
   products += '<td contenteditable id="price"></td>';
   products += '<td><button type="button" class="btn btn-primary btn-xs" id="addBtn">Add</button></td></tr>';
   for(var count=0; count < data.length; count++)
   {
    products +='<tr>';
    products +='<td contenteditable class="" data-id="'+data[count].id+'">'+data[count].id+'</td>';
    products +='<td contenteditable class="column_name text-capitalize" data-column_name="name" data-id="'+data[count].id+'">'+data[count].name+'</td>';
    products += '<td contenteditable class="column_name" data-column_name="description" data-id="'+data[count].id+'">'+data[count].description+'</td>';
    products += '<td contenteditable class="column_name" data-column_name="price" data-id="'+data[count].id+'">'+data[count].price+'</td>';
    products += '<td><button type="button" class="btn btn-danger btn-xs delete" id="'+data[count].id+'">Delete</button></td></tr>';
   }
   $('tbody').html(products);
  }
 });
}

/**Store newly created product */
var _token = $('input[name="_token"]').val();

$(document).on('click', '#addBtn', function(){
 var name = $('#name').text();
 var description = $('#description').text();
 var price = $('#price').text();
 if(name != '' && description != '' && price != '')
 {
  $.ajax({
   url:"{{ route('product.store') }}",
   method:"POST",
   data:{name:name, description:description,price:price, _token:_token},
   success:function(data)
   {
    $('#message').html(data);
    getAllProducts();
   }
  });
 }
 else
 {
  $('#message').html("<div class='alert alert-danger'>The Fields are required<i class='icon fas fa-xmark'></i></div>");
 }
});

/**Hide error message */
$(document).ready(function() {
        $("#message").click(function() {
            $(".alert").hide();
        });
    });

    /**Update product */
$(document).on('blur', '.column_name', function(){
 var column_name = $(this).data("column_name");
 var column_value = $(this).text();
 var id = $(this).data("id");
 
 if(column_value != '')
 {
  $.ajax({
   url:"{{ route('product.update') }}",
   method:"POST",
   data:{column_name:column_name, column_value:column_value, id:id, _token:_token},
   success:function(data)
   {
    $('#message').html(data);
   }
  })
 }
 else
 {
  $('#message').html("<div class='alert alert-danger'>Please enter something<i class='icon fas fa-xmark'></i></div>");
 }
});

/**Delete product */
$(document).on('click', '.delete', function(){
 var id = $(this).attr("id");
 if(confirm("Are you sure you want to delete?"))
 {
  $.ajax({
   url:"{{ route('product.delete') }}",
   method:"POST",
   data:{id:id, _token:_token},
   success:function(data)
   {
    $('#message').html(data);
    getAllProducts();
   }
  });
 }
});

</script>
