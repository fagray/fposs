 <!-- /sales order container -->
    <?php

        $item = Item::where('barcode','=',$code)->get()->first();


    ?>
    <table   class="table table-striped table-bordered">
        <thead>
        <tr>
            <th> Item name </th>
            <th> Quantity</th>
            <th> Price</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td> {{ $item }} </td>
            <td> 23 </td>
            <td> 2303  </td>

        </tr>
        <tr>
            <td> Sample </td>
            <td> 23 </td>
            <td> 2303  </td>

        </tr>
        
        </tbody>
    </table>
