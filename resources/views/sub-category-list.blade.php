<?php $dash.='-- '; ?>
@foreach($subcategories as $subcategory)
    <?php $_SESSION['i']=$_SESSION['i']+1; ?>
    <tr>
        <td>{{$_SESSION['i']}}</td>
        <td>{{$dash}}{{$subcategory->name}}</td>
        <td>{{$subcategory->parent->name}}</td>
       <td>
            <a href="{{Route('editCategory', $subcategory->id)}}">
                <button class="btn btn-sm btn-info">Edit</button>
            </a>
  	        <a href="{{Route('deleteCategory', $subcategory->id)}}">
                <button class="btn btn-sm btn-danger">Delete</button>
            </a>
        </td>
    </tr>
    @if(count($subcategory->subcategory))
        @include('sub-category-list',['subcategories' => $subcategory->subcategory])
    @endif
@endforeach
