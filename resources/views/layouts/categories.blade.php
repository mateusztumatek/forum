@php
    $categories = \App\Category::where('parent_id', null)->get();
    if(isset($category)){
        $c = $category;
    }
@endphp
<div class="w-100 background-white categories-header">
    <div class="container">
        <div class="row">
            <div v-cloak class="col-auto py-0 d-flex align-items-center justify-content-center">
                <p class="font-weight-bold mb-0">Wybierz kategorię</p>
            </div>
            <div class="col-auto py-0">
                <v-toolbar flat>
                    <v-toolbar-items>
                        @foreach($categories as $category)
                            <v-btn v-cloak @if(isset($c)) @if($c->id == $category->id || $c->id == $category->parent_id || $c->parent_id == $category->id) class="active-toolbar-link"  @endif @endif text href="{{$category->url}}">
                                <v-img max-width="30" src="{{url('/storage/'.$category->image)}}" class="mr-1"></v-img>
                                {{$category->name}}
                            </v-btn>
                        @endforeach
                    </v-toolbar-items>
                </v-toolbar>
            </div>
        </div>
    </div>
</div>
@if(isset($c))
    @php
        if($c->parent_id){
            $subcategories = $c->parent->categories;
        }else{
            $subcategories = $c->categories;
        }
    @endphp
    @if(count($subcategories) > 0)
        <div class="w-100 background-white categories-header">
            <div class="container">
                <div class="row">
                    <div class="col-auto py-0 d-flex align-items-center justify-content-center">
                        <p class="font-weight-bold mb-0">Wybierz podkategorię</p>
                    </div>
                    <div class="col-auto py-0">
                        <v-toolbar flat>
                            <v-toolbar-items>
                                @foreach($subcategories as $category)
                                    <v-btn @if(isset($c)) @if($c->id == $category->id) class="active-toolbar-link"  @endif @endif text href="{{$category->url}}">
                                        @if($category->image)
                                        <v-img max-width="30" src="{{url('/storage/'.$category->image)}}" class="mr-1"></v-img>
                                        @endif
                                        {{$category->name}}
                                    </v-btn>
                                @endforeach
                            </v-toolbar-items>
                        </v-toolbar>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif