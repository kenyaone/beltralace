<div class="modal fade" id="logout-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirm logout</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body m-3">
				<p class="mb-0">Are you sure you want to log out? To access this dashboard, you will be forced to log in again.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="confirm-logout">Proceed</button>
			</div>
		</div>
	</div>
</div>

<footer class="footer">
	<div class="container-fluid">
		<div class="row text-muted">
			<div class="col-6 text-start">
				<p class="mb-0">
					<a class="text-muted" href="https://mutevu.com" target="_blank"><strong>Developed by Mutevu</strong></a>
				</p>
			</div>
			<div class="col-6 text-end">
				<ul class="list-inline">
					<!-- <li class="list-inline-item">
            <a class="text-muted" href="" target="_blank">Support</a>
          </li>
          <li class="list-inline-item">
            <a class="text-muted" href="" target="_blank">Help Center</a>
          </li>
          <li class="list-inline-item">
            <a class="text-muted" href="" target="_blank">Privacy</a>
          </li>
          <li class="list-inline-item">
            <a class="text-muted" href="" target="_blank">Terms</a>
          </li> -->
				</ul>
			</div>
		</div>
	</div>
</footer>
</div>
</div>

<div class="settings js-settings">
	<div class="settings-toggle js-settings-toggle">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders align-middle">
			<line x1="4" y1="21" x2="4" y2="14"></line>
			<line x1="4" y1="10" x2="4" y2="3"></line>
			<line x1="12" y1="21" x2="12" y2="12"></line>
			<line x1="12" y1="8" x2="12" y2="3"></line>
			<line x1="20" y1="21" x2="20" y2="16"></line>
			<line x1="20" y1="12" x2="20" y2="3"></line>
			<line x1="1" y1="14" x2="7" y2="14"></line>
			<line x1="9" y1="8" x2="15" y2="8"></line>
			<line x1="17" y1="16" x2="23" y2="16"></line>
		</svg>
	</div>

	<div class="settings js-settings">
		<div class="settings-toggle js-settings-toggle">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders align-middle">
				<line x1="4" y1="21" x2="4" y2="14"></line>
				<line x1="4" y1="10" x2="4" y2="3"></line>
				<line x1="12" y1="21" x2="12" y2="12"></line>
				<line x1="12" y1="8" x2="12" y2="3"></line>
				<line x1="20" y1="21" x2="20" y2="16"></line>
				<line x1="20" y1="12" x2="20" y2="3"></line>
				<line x1="1" y1="14" x2="7" y2="14"></line>
				<line x1="9" y1="8" x2="15" y2="8"></line>
				<line x1="17" y1="16" x2="23" y2="16"></line>
			</svg>
		</div>

		<div class="settings-panel">
			<div class="settings-content">
				<div class="settings-title d-flex align-items-center">
					<button type="button" class="btn-close float-right js-settings-toggle" aria-label="Close"></button>

					<h4 class="mb-0 ms-2 d-inline-block">Explore AdminKit <sup><small class="badge bg-primary text-uppercase">Pro</small></sup></h4>
				</div>

				<div class="settings-body">

					<div class="alert alert-primary" role="alert">
						<div class="alert-message">
							<strong>Hey there!</strong> Choose the color scheme, sidebar and layout that best fits your project needs.
						</div>
					</div>

					<div class="mb-3">
						<span class="d-block fw-bold">Color scheme</span>
						<span class="d-block text-muted mb-2">The perfect color mode for your app.</span>
						<div class="row g-0 text-center mx-n1 mb-2">
							<div class="col">
								<label class="mx-1 d-block mb-1">
									<input class="settings-scheme-label" type="radio" name="theme" value="default">
									<div class="settings-scheme">
										<div class="settings-scheme-theme settings-scheme-theme-default"></div>
									</div>
								</label>
								Default
							</div>
							<div class="col">
								<label class="mx-1 d-block mb-1">
									<input class="settings-scheme-label" type="radio" name="theme" value="colored">
									<div class="settings-scheme">
										<div class="settings-scheme-theme settings-scheme-theme-colored"></div>
									</div>
								</label>
								Colored
							</div>
						</div>
						<div class="row g-0 text-center mx-n1">
							<div class="col">
								<label class="mx-1 d-block mb-1">
									<input class="settings-scheme-label" type="radio" name="theme" value="dark">
									<div class="settings-scheme">
										<div class="settings-scheme-theme settings-scheme-theme-dark"></div>
									</div>
								</label>
								Dark
							</div>
							<div class="col">
								<label class="mx-1 d-block mb-1">
									<input class="settings-scheme-label" type="radio" name="theme" value="light">
									<div class="settings-scheme">
										<div class="settings-scheme-theme settings-scheme-theme-light"></div>
									</div>
								</label>
								Light
							</div>
						</div>
					</div>

					<hr>

					<div class="mb-3">
						<span class="d-block fw-bold">Sidebar layout</span>
						<span class="d-block text-muted mb-2">Change the layout of the sidebar.</span>
						<div>
							<label>
								<input class="settings-button-label" type="radio" name="sidebarLayout" value="default">
								<div class="settings-button">
									Default
								</div>
							</label>
							<label>
								<input class="settings-button-label" type="radio" name="sidebarLayout" value="compact">
								<div class="settings-button">
									Compact
								</div>
							</label>
						</div>
					</div>

					<hr>

					<div class="mb-3">
						<span class="d-block fw-bold">Sidebar position</span>
						<span class="d-block text-muted mb-2">Toggle the position of the sidebar.</span>
						<div>
							<label>
								<input class="settings-button-label" type="radio" name="sidebarPosition" value="left">
								<div class="settings-button">
									Left
								</div>
							</label>
							<label>
								<input class="settings-button-label" type="radio" name="sidebarPosition" value="right">
								<div class="settings-button">
									Right
								</div>
							</label>
						</div>
					</div>

					<hr>

					<div class="mb-3">
						<span class="d-block fw-bold">Layout</span>
						<span class="d-block text-muted mb-2">Toggle container layout system.</span>
						<div>
							<label>
								<input class="settings-button-label" type="radio" name="layout" value="fluid">
								<div class="settings-button">
									Fluid
								</div>
							</label>
							<label>
								<input class="settings-button-label" type="radio" name="layout" value="boxed">
								<div class="settings-button">
									Boxed
								</div>
							</label>
						</div>
					</div>
				</div>

				<div class="settings-footer">
					<div class="d-grid">
						<a class="btn btn-primary btn-lg btn-block" href="" target="_blank">Get AdminKit PRO</a>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<script src="<?php echo ASSETS_PATH; ?>/admin/js/popper.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>/admin/js/app.js"></script>
<script src="<?php echo ASSETS_PATH; ?>/admin/js/jquery.validate.js"></script>
<script src="<?php echo ASSETS_PATH; ?>/admin/js/dropzone.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>/admin/js/doka.min.js"></script>
<!-- <script src="<?php echo ASSETS_PATH; ?>/admin/js/settings.js"></script> -->

<script src="<?php echo ASSETS_PATH; ?>/node_modules/toastr/build/toastr.min.js"></script>
<!-- <script src="<?php echo ASSETS_PATH; ?>/node_modules/bootbox/dist/bootbox.min.js"></script> -->
<script src="<?php echo ASSETS_PATH; ?>/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>/node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>/node_modules/datatables.net-responsive/js/dataTables.responsive.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/i18n/defaults-*.min.js"></script>

<script>
	$(document).ready(function() {
		toastr.options = {
			"closeButton": true,
			"progressBar": true,
			"positionClass": "toast-bottom-right",
			"timeOut": "10000",
		};

		$(document).on('click', '#logout-btn', function(e) {
			e.preventDefault();

			$("#logout-modal").modal('toggle');
		});

		$(document).on('click', '#confirm-logout', function(e) {
			e.preventDefault();
			logout();
		});

		function logout() {
			$.ajax({
				beforeSend: function() {
					$(".preloader").fadeIn();
				},
				complete: function() {
					$(".preloader").fadeOut();
				},
				type: "POST",
				url: "<?php echo DIRADMIN; ?>logout.php",
				data: {
					object: 'User',
					action: 'logout'
				},
				cache: false,
				dataType: "JSON",
				success: function(response) {
					toastr.success(response.message);
					if (response.status == 1) {
						location.reload();
					}
				}
			});
		}
	});

	$.fn.generateSlug = function(string, current_form) {
		if (string != '' && string.length > 0) {
			var slug = $(this).val().toLowerCase().replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '').replace(/[\*\^\'\!]/g, '').split(' ').join('-');
			if (slug.slice(-1) == "-") {
				slug = slug.slice(0, -1);
			}
			$(current_form).find('[name="slug"]').val(slug);
		} else {
			$(current_form).find('[name="slug"]').val('');
		}
	}

	$.fn.checkSlug = function(slug, section, current_record, current_form) {
		if (slug.length > 0) {

			var formData = new FormData();
			formData.append("object", "Page");
			formData.append("action", "check_slug");
			formData.append("section", section);
			formData.append("current_record", current_record);
			formData.append("slug", slug);

			$.ajax({
				url: '<?php echo API; ?>',
				method: 'POST',
				data: formData,
				processData: false,
				dataType: 'json',
				contentType: false,
				success: function(response, textStatus, jqXHR) {
					if (!response) {
						$(current_form).find('[type="submit"]').prop('disabled', true);
						$(current_form).find('[name="slug"]').addClass('is-invalid');
						$('.slug-error').remove();
						$(current_form).find('[name="slug"]').closest('div').append(
							`<small class="text-danger slug-error">
									Slug must be unique. Please edit. Use lowercase and dashes in place of spaces.
							</small>`);
					} else {
						$('.slug-error').remove();
						$(current_form).find('[type="submit"]').prop('disabled', false);
						$(current_form).find('[name="slug"]').removeClass('is-invalid');
						$(current_form).find('[name="slug"]').addClass('is-valid');

					}
				},
				error: function(data) {
					// toastr.error(data.responseJSON.message);
				}
			});
		}
	}


	Dropzone.autoDiscover = false;
	var banner = Doka.create({
		cropAspectRatioOptions: [{
			label: 'Banner',
			value: '20:9'
		}]
	});

	var user_doka = Doka.create({
		cropAspectRatioOptions: [{
			label: 'Square',
			value: '1:1'
		}]
	});

	var event_poster = Doka.create({
		cropAspectRatioOptions: [{
			label: 'Category',
			value: '900:1280'
		}]
	});

	var cover_image = Doka.create({
		cropAspectRatioOptions: [{
			label: 'Cover Image',
			value: '4:3'
		}]
	});

	var header_image = Doka.create({
		cropAspectRatioOptions: [{
			label: 'Header Image',
			value: '24:5'
		}]
	});



	$.fn.initDropzone = function() {
		var id = $(this).attr('id');
		if ($(this.element).hasClass('single')) {
			var limit = 1;
		} else {
			var limit = 25;
		}

		var total_size = 0.0;
		return new Dropzone("#" + id + "", {
			url: '<?php echo API; ?>',
			maxFilesize: 8, // MB
			addRemoveLinks: true,
			maxFiles: 1,
			acceptedFiles: 'image/*,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword',
			dictDefaultMessage: 'Drop a file or click here to upload',
			dictRemoveFile: "Remove",
			transformFile: function(file, done) {
			  myDropZone = this;
			  if (file.type === 'image/jpeg' || file.type === 'image/png') {
			    if (!$(this.element).hasClass('logo')) {
			      if ($(this.element).hasClass('square')) {
			        square.edit(file).then(function(output) {
			          var blob = output.file;
			          myDropZone.createThumbnail(
			            blob,
			            myDropZone.options.thumbnailWidth,
			            myDropZone.options.thumbnailHeight,
			            myDropZone.options.thumbnailMethod,
			            false,
			            function(dataURL) {
			              myDropZone.emit('thumbnail', file, dataURL);
			              done(blob);
			            }
			          );
			        });
			      } else if ($(this.element).hasClass('banner')) {
			        banner.edit(file).then(function(output) {
			          var blob = output.file;
			          myDropZone.createThumbnail(
			            blob,
			            myDropZone.options.thumbnailWidth,
			            myDropZone.options.thumbnailHeight,
			            myDropZone.options.thumbnailMethod,
			            false,
			            function(dataURL) {
			              myDropZone.emit('thumbnail', file, dataURL);
			              done(blob);
			            }
			          );
			        });
			      } else if ($(this.element).hasClass('cover_image')) {
			        cover_image.edit(file).then(function(output) {
			          var blob = output.file;
			          myDropZone.createThumbnail(
			            blob,
			            myDropZone.options.thumbnailWidth,
			            myDropZone.options.thumbnailHeight,
			            myDropZone.options.thumbnailMethod,
			            false,
			            function(dataURL) {
			              myDropZone.emit('thumbnail', file, dataURL);
			              done(blob);
			            }
			          );
			        });
			      } else if ($(this.element).hasClass('header_image')) {
			        header_image.edit(file).then(function(output) {
			          var blob = output.file;
			          myDropZone.createThumbnail(
			            blob,
			            myDropZone.options.thumbnailWidth,
			            myDropZone.options.thumbnailHeight,
			            myDropZone.options.thumbnailMethod,
			            false,
			            function(dataURL) {
			              myDropZone.emit('thumbnail', file, dataURL);
			              done(blob);
			            }
			          );
			        });
			      } else if ($(this.element).hasClass('event_poster')) {
			        event_poster.edit(file).then(function(output) {
			          var blob = output.file;
			          myDropZone.createThumbnail(
			            blob,
			            myDropZone.options.thumbnailWidth,
			            myDropZone.options.thumbnailHeight,
			            myDropZone.options.thumbnailMethod,
			            false,
			            function(dataURL) {
			              myDropZone.emit('thumbnail', file, dataURL);
			              done(blob);
			            }
			          );
			        });
			      } else {
			        var doka = Doka.create();
			        doka.edit(file).then(function(output) {
			          var blob = output.file;
			          myDropZone.createThumbnail(
			            blob,
			            myDropZone.options.thumbnailWidth,
			            myDropZone.options.thumbnailHeight,
			            myDropZone.options.thumbnailMethod,
			            false,
			            function(dataURL) {
			              myDropZone.emit('thumbnail', file, dataURL);
			              done(blob);
			            }
			          );
			        });
			      }
			    } else {
			      myDropZone.createThumbnail(
			        file,
			        myDropZone.options.thumbnailWidth,
			        myDropZone.options.thumbnailHeight,
			        myDropZone.options.thumbnailMethod,
			        false,
			        function(dataURL) {
			          myDropZone.emit('thumbnail', file, dataURL);
			          done(file);
			        }
			      );
			    }
			  } else {
			    done(file);
			  }
			},
			accept: function(file, done) {
				if (total_size > this.options.maxFilesize) {
					file.status = Dropzone.CANCELED;
					this._errorProcessing([file], 'Maximum file size limit reached', null);
					setTimeout(() => {
						this.removeFile(file);
					}, 5000);
				} else {
					done();
				}
			},
			init: function() {
				this.on('sending', function(file, xhr, formData) {
					switch ($(this.element).attr('for')) {
						case 'uploadFile':
							data = [{
									name: 'object',
									value: 'FileManager'
								},
								{
									name: 'action',
									value: 'upload'
								},
							];
							for (var i = 0; i < data.length; i++) {
								if (data[i].name == 'action') {
									data[i].value = 'upload';
								}
								formData.append(data[i].name, data[i].value);
							}
							break;

						case 'uploadPhoto':
							data = [{
									name: 'object',
									value: 'Gallery'
								},
								{
									name: 'action',
									value: 'upload'
								},
							];
							for (var i = 0; i < data.length; i++) {
								if (data[i].name == 'action') {
									data[i].value = 'upload';
								}
								formData.append(data[i].name, data[i].value);
							}
							break;

						default:
							data = [{
									name: 'object',
									value: 'Dropzone'
								},
								{
									name: 'action',
									value: 'upload'
								},
							];
							for (var i = 0; i < data.length; i++) {
								if (data[i].name == 'action') {
									data[i].value = 'upload';
								}
								formData.append(data[i].name, data[i].value);
							}
							$(this.element).closest('form').find('[type="submit"]').prop('disabled', true);
							break;
					}
				});
				this.on('success', function(file, resp) {
					var field_name = $(this.element).attr('data-name');
					if (resp.name) {
						var field_name = $(this.element).attr('data-name');
						if ($('input[name="category_cover_image"]').length) {
							$('input[name="category_cover_image"]').val(resp.path).attr('data-tracker', 'dropzone-element').attr('data-original-name', resp.original_name);
						} else {
							$('form').append('<input type="hidden" name="' + field_name + '" value="' + resp.name + '" data-tracker="dropzone-element" data-original-name="' + resp.original_name + '" >')
						}

					}
					$(this.element).closest('form').find('[type="submit"]').prop('disabled', false);
				});
				this.on('removedfile', function(file) {
					var field_name = $(this.element).attr('data-name');
					if (file.previewElement.id != "") {
						var name = file.previewElement.id;
					} else {
						var name = file.name;
					}
					var original_name = $('input[name="' + field_name + '"][data-original-name="' + name + '"]').val();
					$.ajax({
						headers: {
							'Authorization': 'Bearer <?php echo $_SESSION['user']->id; ?>'
						},
						type: 'POST',
						url: '<?php echo API; ?>',
						data: {
							filename: original_name
						},
						success: function(data) {
							file.previewElement.remove();
							$('input[name="' + field_name + '"][data-original-name="' + name + '"]').remove()
						},
						error: function(e) {
							console.log(e);
						}
					});
				});
				this.on('addedfile', function(file) {
					total_size += parseFloat((file.size / (1024 * 1024)).toFixed(2));
					if ($(this.element).hasClass('multiple')) {
						var allowedFiles = $(this.element).attr('data-files');
						if (this.options.maxFiles == 1) {
							this.options.maxFiles = allowedFiles;
						}
					}
				});
			}
		});
	}
</script>


</body>

</html>