			<section id="one" class="wrapper style1 special">
				<div class="container">
					<header class="major">
						<h2>Geriausi pasiūlymai</h2>
						<p>Pasirinkite geriausią variantą!</p>
					</header>
                    <div class="row 150%">
                        <?php if(isset($_GET['id'])){
                            moreInfo($info);
                        }else{
                            generateDeal($offer);
                        }

                        ?>
                    </div>

				</div>
			</section>
            <script>
                $(document).ready(function() {
                    $('.moreInfo').on('click', function(e) {
                        //e.preventDefault();
                        //$('#forMoreInfo').dialog({width: 'auto'});
                        $('#forMoreInfo').css("display","block");

                    });
                });
            </script>

