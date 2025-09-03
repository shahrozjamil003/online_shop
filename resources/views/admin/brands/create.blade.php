@extends('admin.layout.app')
@section('content')

                <section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Brand</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="brands.html" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<form action="" id="createBrandForm" name="createBrandForm" method="post">
						<div class="container-fluid">
							<div class="card">
								<div class="card-body">								
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="name">Name</label>
												<input type="text" name="name" id="name" class="form-control"  placeholder="Name">	
												<span id="error-name" class="text-danger"></span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="email">Slug</label>
												<input type="text"  readonly name="slug" id="slug" class="form-control" placeholder="Slug">	
												<span id="error-slug" class="text-danger"></span>
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
						</div>
					</form>
					<!-- /.card -->
				</section>
				
				
			
@endsection

@section('customJs')




	<script>

		$('#createBrandForm').submit(function (e) { 
			e.preventDefault();
			var element = $(this);

			$('button[type=submit]').prop('disabled', true);

			$.ajax({
				type: "post",
				url: "{{ route('brand.store') }}",
				data: element.serializeArray(),
				dataType: "json",
				success: function (response) {
					$('button[type=submit]').prop('disabled', false);
					if(response['status'] == true){
						
						window.location.href = "{{ route('brand.index') }}";
						
					}else{
						var errors = response['errors'];
						if(errors['name']){
							$('#error-name').css('display', 'block').html(errors['name']);
						}else{
							$('#error-name').css('display', 'none')
						}

						if(errors['slug']){
							$('#error-slug').css('display', 'block').html(errors['slug']);
						}else{
							$('#error-slug').css('display', 'none')
						}
					}
				}
			});

		});



			$('#name').change(function (e) { 
			var title = $(this);
			
			$.ajax({
				type: "get",
				url: "{{ route('getslug') }}",
				data: {title: title.val()},
				dataType: "json",
				success: function (response) {
					if(response['status'] == true){
						$('#slug').val(response['slug']);
					}
				}
			});
			
		});

		


	

		
	</script>			
	

@endsection