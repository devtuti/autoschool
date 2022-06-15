@foreach($shares as $share)
                    <!-- Post -->
                    <div class="post" id="sid{{$share->sh_id}}">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="{{asset('users/'.$share->u_photo)}}" alt="user image">
                        <span class="username">
                          <a href="#">{{$share->name}}.</a>
                          <a href="javascript:void(0);" class="float-right btn-tool" onclick='return share_delete("{{$share->sh_id}}");'><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">{{$share->sh_date}}</span>
                      </div>
                      <!-- /.user-block -->
                      @if(!empty($share->photo))
                        @if(File::exists("shares/".$share->photo))
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="{{asset('shares/'.$share->photo)}}" alt="Photo">
                        </div>
                        <div class="col-sm-1">
                          <a href="javascript:void(0);" onclick='return share_photo_delete("{{$share->sh_id}}");' class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </div>
                      </div>
                      @endif
                      @endif
                      <p>
                        {!! $share->content_text !!}
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <a href="javascript:void(0);" class="link-black text-sm" onclick='return shares("{{$share->sh_id}}");'> Edit</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <form class="form-horizontal" id="formshare" action="" method="">
                        @csrf
                        <input type="hidden" id="share_edit{{$share->sh_id}}">
                        <div class="input-group input-group-sm mb-0">
                          <input class="form-control form-control-sm" id="sh{{$share->sh_id}}" placeholder="Response">
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-danger">Send</button>
                          </div>
                          <span class="text-danger error-text share_post_error"></span>
                        </div>
                      </form>
                    </div>
                    <!-- /.post -->
                  @endforeach