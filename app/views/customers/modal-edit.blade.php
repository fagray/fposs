<!-- Modal -->
    <div class="modal fade" id="modal-editCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Update Customer</h3>
        </div>
        {{ Form::model($customer,['method' => 'PUT','route' => ['customers.update',
                    $customer->id],'class' => 'form-horizontal','id' => 'modal-edit']) }}

        <div class="modal-body">
            <div class="control-group">
                <label class="control-label" for="customer fname">Customer Firstname</label>
                <div class="controls">
                    {{ Form::text('fname',null,array('autofocus'=> 'autofocus')) }}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="customer lname">Customer Lastname</label>
                <div class="controls">
                    {{ Form::text('lname',null) }}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="customer address">Contact number</label>
                <div class="controls">
                    {{ Form::text('contact_num',null) }}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="customer address">Address</label>
                <div class="controls">
                    {{ Form::textarea('address',null,['cols' => '10','rows' => '3','placeholder' => 'Street/Brgy/City']) }}
                </div> <!-- /controls -->
            </div>

        </div>
        <div class="modal-footer">
            {{ Form::submit('Save',array('class' => 'btn btn-primary')) }}
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
        {{ Form::close() }}
    </div>