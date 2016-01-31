                
                    <div class="control-group">
                        <label class="control-label" for="category name">Item Name</label>
                        <div class="controls">
                            {{ Form::text('name' ,null,array('class' => 'form-control span4 ','autofocus','data-validetta' => 'required')) }}
                        </div> <!-- /controls -->
                       
                    </div>
                   
                    <div class="control-group">
                        <label class="control-label" for="">Description</label>

                        <div class="controls">
                            <div class="input-prepend input-append">

                                {{ Form::textarea('description',null,array('class' => 'form-control span4','rows' => '4','data-validetta' => 'required')) }}

                            </div>
                        </div>	<!-- /controls -->
                    </div>
                    <p class="head-4 dashed bold">Categorization </strong> </p>
                    <div class="control-group">
                        <label class="control-label" for="">Category</label>

                        <div class="controls">
                            <div class="input-prepend input-append">

                                {{ Form::select('category_id',$cat_ids,'',

                                    ['id' => 'category','data-validetta' => 'required']) 
                                }}

                            </div>
                        </div>	<!-- /controls -->
                    </div>
                    <p class="head-4 dashed bold">Pricing </strong> </p>
                    <div class="control-group">
                        <label class="control-label" for="radiobtns">Selling Price/pc</label>

                        <div class="controls">
                            <div class="input-prepend input-append">
                                <span class="add-on">Php</span>
                                {{ Form::number('price',null,array('class' => 'form-control span3','data-validetta' => 'required')) }}
                               

                            </div>
                        </div>	<!-- /controls -->
                    </div>
