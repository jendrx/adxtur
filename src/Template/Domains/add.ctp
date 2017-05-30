<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="row" xmlns="http://www.w3.org/1999/html">
	<div class="col-md-12">
		<legend><?= __('Add Domain') ?></legend>
		<div class="panel panel-default">
            <?= $this->Form->create($domain) ?>


			<div class="row">
				<div class="col-md-3">
                    <?php
                    echo $this->Form->control('name', ['type' => 'text']);
                    echo $this->Form->control('actual_year', ['default' => 2011]);
                    echo $this->Form->control('projection_year', ['default' => 2040]);
                    ?>
				</div>

				<div class="col-md-9">
                    <?php
                    echo $this->Form->control('description');
                    ?>
				</div>

			</div>
		</div>

			<div class=" row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">Territories</div>
						<div class="panel-body" style="height:400px;max-height:450px;">
							<input type="text" id="searchMun" placeholder="Search for municipalities..">
							<div style="height:350px;max-height:370px;overflow-y: scroll">
								<ul id="treeview">
                                    <?php foreach ($municipalities as $municipality): ?>
										<li class="munLi" style="list-style-type: none;"><i
													class="pointer fa fa-caret-right"></i>

											<input value="<?= $municipality->id ?>" type="checkbox"><label
													class="munLabel"><?= $municipality->name ?></label>
											</input>
										</li>


										<ul id="menu<?= $municipality->id ?>" class="parish" style="display:none ">
                                            <?php foreach ($municipality->children as $parish): ?>
												<li style="list-style-type: none;"><input value="<?= $parish->id ?>"
												                                          type="checkbox"/><label><?= $parish->name ?></label>
												</li>
                                            <?php endforeach; ?>
										</ul>
                                    <?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							Selected Territories
						</div>
						<div id="territories_board" class="panel-body"
						     style="height:400px; max-height:450px; overflow:auto"
						     disabled="true">
							<ul id="selected_territories">

							</ul>
                            <?php
                            echo $this->Form->control('territories._ids', ['hidden' => true, 'label' => false]);
                            ?>

						</div>
					</div>

				</div>
			</div>
			<div class="panel-footer">
                <?= $this->Form->button(__('Submit'), ['class' => 'button']) ?>
                <?= $this->Form->end() ?>
			</div>
		</div>
	</div>



<script>

    $(document).ready(function () {

        $(".pointer").click(function () {
            $header = $(this);
            //console.log($header);
            //getting the next element

            $content = $header.closest('li').next();

            //$content = $header.find(".parish");
            //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
            $content.slideToggle(1000, function () {
                //execute this after slideToggle is done
                //change text of header based on visibility of content div
            });
        });

        $(".munLabel").click(function () {
            $header = $(this);
            //console.log($header);
            //getting the next element

            $content = $header.closest('li').next();

            $content.find(':checkbox').each(function()
            {
                if(!(this.checked)) $(this).prop('checked',true).change();
            });

            $content.slideToggle(1000, function () {
                //execute this after slideToggle is done
                //change text of header based on visibility of content div
            });
        });

        $("#searchMun").keyup(function () {

            var filter = $(this).val().toUpperCase();

            $(".parish").each(function () {
                this.style.display = 'none';
            });


            $('#treeview > li').each(function () {
                var text_label = $(this).find(".munLabel");

                if ($(text_label).text().toUpperCase().indexOf(filter) > -1) {
                    this.style.display = 'block';
                } else {
                    //this.style.display = "none";
                    this.style.display = 'none';
                }
            });
        });

        $("#treeview :checkbox").change(function(){
            var label = ($(this).next());

            var text= $(label).text();
            var key = $(this).val();
            if (this.checked)
            {
                $('#territories-ids').append($("<option></option>").attr({"value":key}).text(text).prop({"selected":true}));
                $('#selected_territories').append($('<li>',{'text':text}))

            }

            if (!(this.checked))
            {
                $("#territories-ids option[value="+key+"]").remove();
                $("#selected_territories").find('li:contains('+text+')').remove();

            }



        });

    })
</script>
