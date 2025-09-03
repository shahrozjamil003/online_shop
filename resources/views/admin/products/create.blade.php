@extends('admin.layout.app')
    @section('content')
<!-- Content Header (Page header) -->
        <section class="content-header">					
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Product</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="products.html" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <form action="" id="productform" method="post">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">								
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Title</label>
                                                <input type="text"  name="title" id="title" class="form-control" placeholder="Title">	
                                                <span id="title_error" class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">	
                                                 <span id="slug_error" class="text-danger"></span>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                 <span id="description_error" class="text-danger"></span>
                                                <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                            </div>
                                        </div>                                            
                                    </div>
                                </div>	                                                                      
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Media</h2>		
                                     <span id="image_error" class="text-danger"></span>						
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">    
                                            <br>Drop files here or click to upload.<br><br>                                            
                                        </div>
                                    </div>
                                </div>	                                                                      
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Pricing</h2>								
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Price</label>
                                                <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                                 <span id="price_error" class="text-danger"></span>	
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="compare_price">Compare at Price</label>
                                                <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                                 <span id="compare_price_error" class="text-danger"></span>
                                                <p class="text-muted mt-3">
                                                    To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                                </p>	
                                            </div>
                                        </div>                                            
                                    </div>
                                </div>	                                                                      
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Inventory</h2>								
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                                <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">	
                                                 <span id="sku_error" class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="barcode">Barcode</label>
                                                <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode">	
                                                 <span id="barcode_error" class="text-danger"></span>
                                            </div>
                                        </div>   
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="hidden" name="track_qty" value="no">
                                                    <input class="custom-control-input" type="checkbox" id="track_qty" value="yes" name="track_qty" checked>
                                                    <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                </div>
                                                 <span id="track_qty_error" class="text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">	
                                                 <span id="qty_error" class="text-danger"></span>
                                            </div>
                                        </div>                                         
                                    </div>
                                </div>	                                                                      
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">	
                                    <h2 class="h4 mb-3">Product status</h2>
                                    <div class="mb-3">
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                         <span id="status_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="card">
                                <div class="card-body">	
                                    <h2 class="h4  mb-3">Product category</h2>
                                    <div class="mb-3">
                                        <label for="category">Category</label>
                                        <select name="category" id="category" class="form-control">

                                            <option value="">Select Category</option>
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                           
                                        </select>
                                         <span id="category_error" class="text-danger"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category">Sub category</label>
                                        <select name="sub_category" id="sub_category" class="form-control">
                                            <option value="">Select Sub Category</option>
                                            
                                        </select>
                                         <span id="sub_category_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="card mb-3">
                                <div class="card-body">	
                                    <h2 class="h4 mb-3">Product brand</h2>
                                    <div class="mb-3">
                                        <select name="brand" id="brand" class="form-control">
                                            <option value="">Select Brand</option>
                                            @if($brands->isNotEmpty())
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                         <span id="status_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="card mb-3">
                                <div class="card-body">	
                                    <h2 class="h4 mb-3">Featured product</h2>
                                    <div class="mb-3">
                                        <select name="is_featured" id="is_featured" class="form-control">
                                            <option value="no">No</option>
                                            <option value="yes">Yes</option>                                                
                                        </select>
                                         <span id="is_featured_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>                                 
                        </div>
                    </div>
                    
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </div>
            </form>
            <!-- /.card -->
        </section>
    @endsection    

    @section('customJs')

        <script>



            $('#title').change(function (e) { 
                e.preventDefault();
                var title = $(this).val();

                $.ajax({
                    type: "get",
                    url: "{{ route('getslug') }}",
                    data: {title: title},
                    dataType: "json",
                    success: function (response) {
                        if(response['status'] == true){
                           $('#slug').val(response['slug']);
                        }
                    }
                });
                
            });

            $('#category').change(function(e) {
                e.preventDefault();
                var category_id = $(this).val();

                $.ajax({
                    type: "get",
                    url: "{{ route('getsubcategory') }}",
                    data: {category_id: category_id},
                    dataType: "json",
                    success: function (response) {
                        $('#sub_category').find('option').not(':first').remove();
                       $.each(response['subcategories'], function (key, item) { 
                            $('#sub_category').append("<option value='" + item.id + "'>" + item.name + "</option>");
                        });

                    }
                });
            })

            $('#productform').submit(function (e) { 
                e.preventDefault();
                var request = $(this);

                $.ajax({
                    type: "post",
                    url: "{{ route('product.store') }}",
                    data: request.serializeArray(),
                    dataType: "json",
                    success: function (response) {
                        if(response['status'] == true){

                        }else{
                            var errors = response['errors'];
                             $('.text-danger').html('');
                            $.each(errors, function (key, value) { 
                               
                                $('#'+key+'_error').html(value[0]);
                            });
                        }
                    },
                    error: function(){
                        console.log('something went wrong');
                        
                                                
                    }
                    
                });
                
            });

            const dropzone = new Dropzone("#image", {
            url: "{{ route('tem-images.create') }}",
            paramName: 'image',
            maxFiles: 1,
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

