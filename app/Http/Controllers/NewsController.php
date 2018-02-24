<?php

namespace App\Http\Controllers;

use App\Http\Requests\News\CreateNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\FileHandler;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use App\Helpers\Constant;



class NewsController extends Controller {
	
	/**
	 * Return all news
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		
		if($news = News::orderBy( 'created_at', 'desc' )->paginate( 6 )) {
			return response()->myJson( 200, 'Successfully get all news.', $news );
		} else {
			return response()->myJson( 404, 'Can\'t get all news.', $news );
		}
	}
	
	/**
	 * Return last 6 news
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function lastSix() {
		$news = News::orderBy( 'created_at', 'desc' )->take( 6 )->get();
		if(!$news->isEmpty()) {
			return response()->myJson( 200, 'Successfully get last 6 news.', $news );
		} else {
			return response()->myJson( 404, 'Can\'t get last 6 news.', $news );
		}
	}
	
	/**
	 * Return last 6 news for locum
	 *
	 * @return mixed
	 */
	public function lastSixLocum() {
		$news = News::where( 'for_locum', 1 )->orderBy( 'created_at', 'desc' )->take( 6 )->get();
		if(!$news->isEmpty()) {
			return response()->myJson( 200, 'Successfully get last 6 news.', $news );
		} else {
			return response()->myJson( 404, 'Can\'t get last 6 news.', $news );
		}
	}
	
	/**
	 * Return last 6 news for practice
	 *
	 * @return mixed
	 */
	public function lastSixPractice() {
		$news = News::where( 'for_practice', 1 )->orderBy( 'created_at', 'desc' )->take( 6 )->get();
        if(!$news->isEmpty()) {
			return response()->myJson( 200, 'Successfully get last 6 news.', $news );
		} else {
			return response()->myJson( 404, 'Can\'t get last 6 news.', $news );
		}
    }
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Http\Requests\News\CreateNewsRequest $request
	 * @return \Illuminate\Http\Response
	 * @internal param $
	 */
	public function store( CreateNewsRequest $request ) {
		
		$news = new News;
		$news->fill( $request->all() );
		
		if($news->save()) {
			return response()->myJson( 200, 'Successfully created new news.', $news );
		} else {
			return response()->myJson( 400, 'Can\'t create news.', $news );
		}
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		$news = News::findOrFail( $id );
		
		if($news) {
			return response()->myJson( 200, 'Successfully retrieved news.', $news );
		} else {
			return response()->myJson( 400, 'Can\'t retrieved news.', $news );
		}
	}
	
	/**
	 * Update the specified resource in storage.
	 * @param \Illuminate\Http\Request $request
	 * @param \App\News                $news
	 * @return
	 */
	public function update( Request $request, News $news ) {
        $fileHandler = new FileHandler;
        $file        = $request->file( 'files' );
        $basePath    = Constant::absolutePath( "NEWS_AVATAR_PATH" );

        if($file) {
            $image = Image::make($file->getRealPath());
            $image->fit(200,200, function ($constraint) {
                $constraint->upsize();
            });
            $name = md5( Carbon::now() ) . '.' . $file->getClientOriginalExtension();
            $image->save($basePath . $name);
            if($news->getOriginal( 'avatar' ) != Constant::NEWS_DEFAULT_AVATAR_PATH) {
                $fileHandler->removeFile(public_path() . $news->avatar);
            }
            $news->avatar =Constant::NEWS_AVATAR_PATH .$name;

        }else{
            $news->fill( $request->all() );
        }

		if($news->save()) {
			return response()->myJson( 200, 'Successfully edited news.', $news );
		} else {
			return response()->myJson( 400, 'Can\'t edited news.', $news );
		}
	}
    public function updateAvatar( Request $request, $id ) {
	    $news = News::find($id);
        $fileHandler = new FileHandler;
        $file        = $request->file( 'files' );
        $basePath    = Constant::absolutePath( "NEWS_AVATAR_PATH" );

        if($file) {
            $image = Image::make($file->getRealPath());
            $image->fit(200,200, function ($constraint) {
                $constraint->upsize();
            });
            $name = md5( Carbon::now() ) . '.' . $file->getClientOriginalExtension();
            $image->save($basePath . $name);
            if($news->getOriginal( 'avatar' ) != Constant::NEWS_DEFAULT_AVATAR_PATH) {
                $fileHandler->removeFile(public_path() . $news->avatar);
            }
            $news->avatar =Constant::NEWS_AVATAR_PATH .$name;

        }
        $news->fill( $request->all() );
        if($news->save()) {
            return response()->myJson( 200, 'Successfully edited news.', $news );
        } else {
            return response()->myJson( 400, 'Can\'t edited news.', $news );
        }
    }
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\News $news
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 */
	public function destroy( News $news ) {
		if(News::destroy( $news->id ) > 0) {
			return response()->myJson( 200, 'Successfully deleted news.', NULL );
		} else {
			return response()->myJson( 400, 'Can\'t deleted news.', $news );
		}
	}
}
