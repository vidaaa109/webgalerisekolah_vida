@php($authUser = auth('user')->user())
<div class="comment-item mb-3 pb-3 border-bottom" data-comment-id="{{ $comment->id }}">
  <div class="d-flex gap-2">
    <div class="flex-shrink-0">
      @if($comment->user?->profile_photo_path)
        <img src="{{ asset('storage/'.$comment->user->profile_photo_path) }}?v={{ $comment->user->updated_at?->timestamp ?? now()->timestamp }}" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;" alt="">
      @else
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#e2e8f0;color:#64748b;font-weight:700;font-size:14px;">
          {{ strtoupper(substr($comment->user?->name ?? 'U',0,1)) }}
        </div>
      @endif
    </div>
    <div class="flex-grow-1">
      <div class="fw-bold small d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span>{{ $comment->user?->name ?? 'Pengguna' }}</span>
        @if($authUser)
        <div class="d-flex gap-2 align-items-center">
          @if($comment->user_id === $authUser->id)
          <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirm('Hapus komentar ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link p-0 text-muted text-decoration-none small">Hapus</button>
          </form>
          @else
          <form method="POST" action="{{ route('reports.store') }}">
            @csrf
            <input type="hidden" name="type" value="comment">
            <input type="hidden" name="target_id" value="{{ $comment->id }}">
            <input type="hidden" name="reason" value="Komentar tidak pantas dan melanggar aturan.">
            <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none small">Laporkan</button>
          </form>
          @if($comment->user)
          <form method="POST" action="{{ route('reports.store') }}">
            @csrf
            <input type="hidden" name="type" value="user">
            <input type="hidden" name="target_id" value="{{ $comment->user->id }}">
            <input type="hidden" name="reason" value="Pengguna melakukan pelanggaran di kolom komentar.">
            <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none small">Laporkan Akun</button>
          </form>
          @endif
          @endif
        </div>
        @endif
      </div>
      <div class="text-muted" style="font-size:12px;">{{ $comment->created_at->locale('id')->diffForHumans() }}</div>
      <p class="mb-1 mt-1">{{ $comment->body }}</p>
      @foreach(($comment->children ?? collect())->where('status', 'visible')->sortBy('created_at') as $child)
        <div class="mt-2 ps-4 border-start">
          <div class="d-flex gap-2">
            <div class="flex-shrink-0">
              @if($child->user?->profile_photo_path)
                <img src="{{ asset('storage/'.$child->user->profile_photo_path) }}?v={{ $child->user->updated_at?->timestamp ?? now()->timestamp }}" class="rounded-circle" style="width:32px;height:32px;object-fit:cover;" alt="">
              @else
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:#e2e8f0;color:#64748b;font-weight:700;font-size:12px;">
                  {{ strtoupper(substr($child->user?->name ?? 'U',0,1)) }}
                </div>
              @endif
            </div>
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="fw-semibold small">{{ $child->user?->name ?? 'Pengguna' }}</span>
                <div class="d-flex gap-2 align-items-center">
                  <small class="text-muted">{{ $child->created_at->locale('id')->diffForHumans() }}</small>
                  @if($authUser)
                    @if($child->user_id === $authUser->id)
                    <form method="POST" action="{{ route('comments.destroy', $child) }}" onsubmit="return confirm('Hapus komentar ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-link p-0 text-muted text-decoration-none small">Hapus</button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('reports.store') }}">
                      @csrf
                      <input type="hidden" name="type" value="comment">
                      <input type="hidden" name="target_id" value="{{ $child->id }}">
                      <input type="hidden" name="reason" value="Komentar tidak pantas dan melanggar aturan.">
                      <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none small">Laporkan</button>
                    </form>
                    @if($child->user)
                    <form method="POST" action="{{ route('reports.store') }}">
                      @csrf
                      <input type="hidden" name="type" value="user">
                      <input type="hidden" name="target_id" value="{{ $child->user->id }}">
                      <input type="hidden" name="reason" value="Pengguna melakukan pelanggaran di kolom komentar.">
                      <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none small">Laporkan Akun</button>
                    </form>
                    @endif
                    @endif
                  @endif
                </div>
              </div>
              <p class="mb-1">{{ $child->body }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

