@extends('admin.layout.app')

@section('content')

<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Category</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="categories.html" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
                        <form action="" method="POST" name="categoryForm" id="categoryForm">

                            <div class="card">
                                <div class="card-body">								
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Name">	
                                                <span class="text-danger" id="error-name"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email">Slug</label>
                                                <input type="text" name="slug" id="slug" class="form-control" readonly >	
                                                <span class="text-danger" id="error-slug"></span>
                                            </div>
                                        </div>

                                        <input type="hidden" name="image_id" id="image_id" class="form-control" >	
                                                
                                                

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="image">Image</label>
                                                <div id="image" class="dropzone dz-clickable">
                                                    <div class="dz-message needsclick">
                                                       <br> Drop file here or click to upload. <br><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status">Status</label>
                                                <select name="status" id="" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="0">Block</option>
                                                </select>
                                                	
                                            </div>
                                        </div>
                                    </div>
                                </div>							
                            </div>

                        
                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </form>
					</div>
                    
					<!-- /.card -->
				</section>


@endsection

@section('customJs')
 <script>
    $("#categoryForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        var dataarray = element.serializeArray();
        
       
        
        $.ajax({
            
            url: '{{ route("categories.store") }}',
            type: 'POST',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);
                if(response['status'] == true){
                    $("#error-name").css('display', 'none');
                    $("#error-slug").css('display', 'none');
                    window.location.href="{{route('categories.index')}}";
                }else{
                    var errors = response['errors'];

                    if(errors['name']){
                        $("#error-name").css('display', 'block').html(errors['name']);
                    }else{
                        $("#error-name").css('display', 'none');
                    }

                    if(errors['slug']){
                        $("#error-slug").css('display', 'block').html(errors['slug']);
                    }else{
                        $("#error-slug").css('display', 'none');
                    }
                }     
               
            }, error: function(errors){
               
                
            }

        });
    });


    $('#name').change(function(){
        var title = $(this);

        $.ajax({
            url: '{{ route("getslug") }}',
            type: 'get',
            data: { title: title.val() },
            dataType: 'json',
            success: function(response){
                if(response['status'] == true){
                    $('#slug').val(response['slug']);
                }
            }
        });
    });

    Dropzone.autoDiscover = false;

    const dropzone = new Dropzone("#image", {
        url: "{{ route('tem-images.create') }}",
        paramName: 'image',
        maxFiles: 10,
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg, image/png, image/jpg",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

    init: function () {
        this.on('addedfile', function (file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]);
            }
        });
    },

    success: function (file, response) {
        $("#image_id").val(response.image_id);  // Correct selector
    }
    });
 </script>
    

@endsection