@extends('admin.layout.app')

@section('content')

		<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Sub Category</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="subcategory.html" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<form action="" id="sub-categoryform" method="post">
							<div class="card">
								<div class="card-body">								
									<div class="row">
										<div class="col-md-12">
											<div class="mb-3">
												<label for="category">Category</label>
											
												<select name="category" id="category" class="form-control">
													<option value="">Select a Category</option>
													@if ($categories->count() > 0)
														@foreach ($categories as $category)
															<option value="{{ $category->id }}">{{ $category->name }}</option>
														@endforeach
													@endif
													
												
												</select>
												<span class="text-danger" id="category-error"></span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="name">Name</label>
												<input type="text" name="name" id="name" class="form-control" placeholder="Name">	
												<span class="text-danger" id="error-name"></span>
											</div>
											
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="slug">Slug</label>
												<input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">
												<span class="text-danger" id="error-slug"></span>	
											</div>
										</div>	
										
										<div class="col-md-6">
											<div class="mb-3">
												<label for="status">Status</label>
												<select name="status" id="status" class="form-control">
													<option value="1">Active</option>
													<option value="0">Block</option>
													<span class="text-danger" id="error-status"></span>
												</select>
											</div>
										</div>	
									</div>
								</div>							
							</div>
							
						
							<div class="pb-5 pt-3">
								<button class="btn btn-primary">Create</button>
								<a href="subcategory.html" class="btn btn-outline-dark ml-3">Cancel</a>
							</div>
						</form>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->			
					


@endsection

@section('customJs')
 
    <script>
		$("#sub-categoryform").submit(function (e) { 
    e.preventDefault();
    var formdata = $(this).serializeArray();

    $.ajax({
        url: '{{ route("sub-categories.store") }}',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(response){
            if(response['status'] == true){
                $("#error-name").css('display', 'none');
                $("#error-slug").css('display', 'none');
                $("#category-error").css('display', 'none');
				window.location.href = "{{ route('sub-categories.index') }}";
            } else {
                var errors = response['errors'];

                if(errors['category']){
                    $("#category-error").css('display', 'block').html(errors['category']);
                } else {
                    $("#category-error").css('display', 'none');
                }

                if(errors['name']){
                    $("#error-name").css('display', 'block').html(errors['name']);
                } else {
                    $("#error-name").css('display', 'none');
                }

                if(errors['slug']){
                    $("#error-slug").css('display', 'block').html(errors['slug']);
                } else {
                    $("#error-slug").css('display', 'none');
                }
            }
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

    </script>

@endsection