<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $articles = Article::where('is_active','1')->with('tags')->where('is_active','1')->paginate(10);

        return view('backend.articles.index', compact('articles','filter','published','unpublished','archived','all'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $article = '';

        return view('backend.articles.crud', compact('categories','article') );
    }


    public function store(Request $request)
    {

        if($request->link_bool == "true"){

          $this->validate($request, [
              'title' => 'required|min:3',
              'slug' => 'required|min:3',
              'image_e' => 'required|min:6',
              'content' => 'required|min:6',
          ]);


            $url = $request->image_e;
            $contents = file_get_contents($url);
            $imageName = substr($url, strrpos($url, '/') + 1);
            $imageName = time().$imageName;
            Storage::disk('public')->put($imageName, $contents);

            // file_put_contents(public_path('uploads/images/'+$imageName), $contents);
            // Storage::disk('local')->get($url);
            // $name = substr($url, strrpos($url, '/') + 1);

        }else{

          $this->validate($request, [
              'title' => 'required|min:3',
              'slug' => 'required|min:3',
              'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
              'content' => 'required|min:6',
          ]);

            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/images'), $imageName);
            // $request->image->move(public_path('photos/shares'), $imageName);
        }

        // if the slug exist !
        $art_slug = Article::where('slug', $request->slug)->count();
        if($art_slug > 0){
            return "Slug exist déja veillez modifier le titre ! ";
        }else{
            $slug = $request->slug;
        }


        $id_user = Auth::user()->id;
        $user = User::where('id', $id_user)->first();

        $art = Article::create([
            'title' => $request->title,
            'slug' => $slug,
            'image_featured' => $imageName,
            'content' => $request->content,
            'source' => $request->source,
            'subtitle' => $request->subtitle,
            'intro' => $request->intro,
            'author' => $request->author,
            'published_at' => $request->published_at,
            'is_published' => $request->is_published,
            'is_active' => $request->is_active,
            'is_featured' => $request->is_featured,
        ]);

        $art->save();

        $article = Article::where('slug', $slug)
            ->firstOrFail();
        
            
        if( !empty($request->video) ){
                
            parse_str( parse_url( $request->video, PHP_URL_QUERY ), $id_video );
            $video_id = $id_video['v']; 

            $video = Media::create([
                'title' => $video_id,
                'path' => $request->video,
                'type' => 'vid',
                'id_user' => $id_user,
                'is_active' => 1,
            ]);
            $video->save();
            $article->medias()->attach($video->id);

        }

        if ($request->hasFile('photos')) {
            
            foreach ($request->photos as $photo) {
                // $filename = $photo->store('photos');
                
                $str = '12345789';
                $shuffled = str_shuffle($str);
    
    
                $imageName = time().'_'.$shuffled.'.'.$photo->getClientOriginalExtension();
                $photo->move(public_path('uploads/images'), $imageName);
    
                $article_photo = Media::create([
                    'title' => $imageName,
                    'type' => 'img',
                    'id_user' => $id_user,
                    'is_active' => 1,
                ]);
    
                $article_photo->save();
    
                $article->medias()->attach($article_photo->id);
            }
        }
        

        $new_tags = explode(',', $request->tag_list);

        if( $request->input('tag_list') )
        {
            foreach($new_tags as $new_tag)
            {
                $tag_test = Tag::where('name', $new_tag)
                    ->orWhere('slug', $new_tag)
                    ->first();

                if( $tag_test ){
                    // Found it
                    $tag = Tag::where('name', $new_tag)
                    ->orWhere('slug', $new_tag)
                    ->first();

                    $article->tags()->attach($tag->id);

                }else{
                    // Not found !
                    $tag = $user->tags();
                    $tag_slug = str_slug($new_tag);
                    $tag = $tag->create([
                        'name' => $new_tag,
                        'slug' => $tag_slug,
                    ]);
                    $tag->save();
                    $article->tags()->attach($tag->id);
                }
            }
        }

        $new_cats = explode(',', $request->nom_cat);

        if( $request->input('nom_cat') )
        {

            foreach($new_cats as $new_cat)
            {
                $cat_test = Category::where('name', $new_cat)
                    ->orWhere('slug', $new_cat)
                    ->first();

                if( $cat_test ){
                    // Found it
                    $cat = Category::where('name', $new_cat)
                    ->orWhere('slug', $new_cat)
                    ->first();

                    $article->categories()->attach($cat->id);

                }else{
                    // Not found !
                    $cat = $user->categories();
                    $slug_cat = str_slug($new_cat);
                    $cat = $cat->create([
                        'name' => $new_cat,
                        'slug' => $slug_cat,
                    ]);

                    $cat->save();

                    $article->categories()->attach($cat->id);
                }

            }
        }


        $article->users()->attach($id_user);

        $article = Article::where('id', $article->id)
            ->orWhere('slug', $article->slug)
            ->firstOrFail();

        $categories = Category::all();

        return redirect()->route('articles.edit', compact('article','categories'));

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {
        $article = Article::where('id', $param)
            ->orWhere('slug', $param)
            ->firstOrFail();

        if(filter_var($article->image_featured, FILTER_VALIDATE_URL))
        {
            $link = true;
        }
        else
        {
            $link = false;
        }

        return view('backend.articles.show', compact('article','link'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($param)
    {
        $article = Article::where('id', $param)
            ->orWhere('slug', $param)
            ->firstOrFail();

        $categories = Category::all();

        return view('backend.articles.crud', compact('article','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $param)
    {
        // $this->validate($request, [
        //     'title' => 'required|min:3',
        //     'slug' => 'required|min:3',
        //     'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'content' => 'required|min:6',
        // ]);

        $article = Article::where('id', $param)
            ->orWhere('slug', $param)
            ->firstOrFail();


        if( $request->link_bool != "neutre" ) {

            if( $request->link_bool == "true" ){

                $this->validate($request, [
                    'title' => 'required|min:3',
                    'slug' => 'required|min:3',
                    'image_e' => 'required|min:6',
                    'content' => 'required|min:6',
                ]);

                $url = $request->image_e;
                $contents = file_get_contents($url);
                $imageName = substr($url, strrpos($url, '/') + 1);
                $imageName = time().$imageName;

                $imageName = time().'.jpg';

                Storage::disk('public')->put($imageName, $contents);
            }elseif($request->link_bool == "false"){

                $this->validate($request, [
                        'title' => 'required|min:3',
                        'slug' => 'required|min:3',
                        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                        'content' => 'required|min:6',
                    ]);

                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('uploads/images'), $imageName);
            }


            $article->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'image_featured' => $imageName,  // Image
                'content' => $request->content,
                'source' => $request->source,
                'subtitle' => $request->subtitle,
                'intro' => $request->intro,
                'author' => $request->author,
                'is_active' => $request->is_active, 
                'is_featured' => $request->is_featured, 
                'is_published' => $request->is_published, 
                'published_at' => $request->published_at, 
            ]);


        }else{

            $article->update([  // No image
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'source' => $request->source,
                'subtitle' => $request->subtitle,
                'intro' => $request->intro,
                'author' => $request->author,
                'is_active' => $request->is_active, 
                'is_featured' => $request->is_featured, 
                'is_published' => $request->is_published, 
                'published_at' => $request->published_at, 
            ]);

            $id_user = Auth::user()->id;
            $user = User::where('id', $id_user)->first();
            
            
            if( !empty($request->video) ){
                
                parse_str( parse_url( $request->video, PHP_URL_QUERY ), $id_video );
                $video_id = $id_video['v']; 

                $video = Media::create([
                    'title' => $video_id,
                    'path' => $request->video,
                    'type' => 'vid',
                    'id_user' => $id_user,
                    'is_active' => 1,
                ]);
                $video->save();
                $article->medias()->attach($video->id);
            }
            
            if ($request->hasFile('photos')) {
                
                foreach ($request->photos as $photo) {
                    // $filename = $photo->store('photos');
                    
                    $str = '12345789';
                    $shuffled = str_shuffle($str);
        
        
                    $imageName = time().'_'.$shuffled.'.'.$photo->getClientOriginalExtension();
                    $photo->move(public_path('uploads/images'), $imageName);
        
                    $article_photo = Media::create([
                        'title' => $imageName,
                        'type' => 'img',
                        'id_user' => $id_user,
                        'is_active' => 1,
                    ]);
                        
                    $article_photo->save();
        
                    $article->medias()->attach($article_photo->id);
                }
            }

            $new_tags = explode(',', $request->tag_list);
            $article->tags()->detach();

            if( $request->input('tag_list') )
            {
                $article->tags()->detach();

                foreach($new_tags as $new_tag)
                {
                    $tag_test = Tag::where('name', $new_tag)
                        ->orWhere('slug', $new_tag)
                        ->first();

                    if( $tag_test ){
                        // Found it
                        $tag = Tag::where('name', $new_tag)
                        ->orWhere('slug', $new_tag)
                        ->first();

                        $article->tags()->attach($tag->id);

                    }else{
                        // Not found !
                        $tag = $user->tags();
                        $tag_slug = str_slug($new_tag);
                        $tag = $tag->create([
                            'name' => $new_tag,
                            'slug' => $tag_slug,
                        ]);

                        $tag->save();

                        $article->tags()->attach($tag->id);
                    }
                }
            }

            $new_cats = explode(',', $request->nom_cat);
            // $article->categories()->detach();

            if( $request->input('nom_cat') )
            {
                $article->categories()->detach();

                foreach($new_cats as $new_cat)
                {
                    $cat_test = Category::where('name', $new_cat)
                        ->orWhere('slug', $new_cat)
                        ->first();

                    if( $cat_test ){
                        // Found it
                        $cat = Category::where('name', $new_cat)
                        ->orWhere('slug', $new_cat)
                        ->first();

                        $article->categories()->attach($cat->id);

                    }else{
                        // Not found !
                        $cat = $user->categories();
                        $cat_slug = str_slug($new_cat);
                        $cat = $cat->create([
                            'name' => $new_cat,
                            'slug' => $cat_slug,
                        ]);

                        $cat->save();
                        $article->categories()->attach($cat->id);
                    }
                }
            }
        }

        $categories = Category::all();

        return redirect( route('articles.edit', compact('article', 'categories') ) );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($param)
    {
        Article::where('id', $param)
            ->orWhere('slug', $param)
            ->delete();

        Session::flash('title', 'Delete');
        Session::flash('icon', 'error');
        Session::flash('message', 'The Article '.$param.' has been Deleted !');

        return redirect()->back();
    }

}
