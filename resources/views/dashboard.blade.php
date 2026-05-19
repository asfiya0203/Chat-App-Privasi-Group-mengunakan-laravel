<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="dashboard-container">
    <div class="sidebar">
        <div class="sidebar-logo"> App Chat </div>
        <a href="/group/create" class="chat-link">
            <button class="tombol buat-group"> Buat Grup </button>
        </a>
        <div class="contact-item search-item">
            <span>🔍</span>
            <input type="text" placeholder="Search...">
        </div>
        <div class="sidebar-card">
            <div class="section-title"> Private</div>

            @foreach($users as $user)
            <a href="{{ route('chat.buka', $user->id) }}" class="chat-link" >
                <div class="contact-item" data-user-id="{{ $user->id }}">
                    <div class="contact-name">{{ $user->name }}</div>
                    <span class="status-dot offline"></span>
                </div>
            </a>
            @endforeach

            <div class="section-title">Group</div>

            @foreach($groupChats as $group)
            <a href="{{ route('chat.show', $group->id) }}" class="chat-link">
                <div class="contact-item">
                    <div class="contact-name">{{ $group->name }}</div>
                </div>
            </a>
            @endforeach
            
        </div>
    </div>


    <div class="chat-area">

        @if(isset($percakapan))
        <div class="chat-header">
            <div class="nama">
                @if($percakapan->type == 'group')
                        {{ $percakapan->name }}
                    @else
                        {{ $lawanBicara?->name ?? 'Unknown' }}
                    @endif
            </div>
                <div class="status">
                    Online
                </div>
        </div>

        <div class="chat-body" id="chat-body">

            @foreach($pesanList as $pesan)
            @if($pesan->user_id === auth()->id())
            
            <div class="chat chat-end">
                <div class="chat-bubble">{{ $pesan->body }}
                    <span class="chat-time">{{ $pesan->created_at->format('H:i') }}</span>
                </div>
            </div>

                @else
                <div class="chat chat-start">
                    <div class="chat-bubble"> {{ $pesan->body }}
                        <span class="chat-time">{{ $pesan->created_at->format('H:i') }}</span>
                    </div>
                </div>

                @endif
            @endforeach
        </div>
        
    <div class="chat-input">
        <input type="text" id="input-pesan" placeholder="Ketik pesan...">
        <button id="btn-kirim">Kirim</button>
    </div>

        @else
        <p>Pilih kontak untuk mulai chat</p>

        @endif
    </div>
</div>

<script>
    const chatBody = document.getElementById('chat-body');
    if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;

    async function loadMessages() {
        const response = await fetch(window.location.href);
        const text = await response.text();
        const parser = new DOMParser();
        const htmlDocument = parser.parseFromString(text, 'text/html');
        const newMessages =
            htmlDocument.getElementById('chat-body').innerHTML;
        chatBody.innerHTML = newMessages;
        scrollToBottom();
    }
    setInterval(loadMessages, 2000);

    const btnKirim = document.getElementById('btn-kirim');
    const inputPesan = document.getElementById('input-pesan');

    if (btnKirim) {
        btnKirim.addEventListener('click', async () => {
            const body = inputPesan.value.trim();
            if (!body) return;

            const percakapanId = {{ $percakapan->id ?? 'null' }};
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            const res = await fetch(`/chat/${percakapanId}/kirim`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ body }),
            });

            const data = await res.json();

            if (data.status === 'ok') {
                const div = document.createElement('div');
                div.className = 'chat chat-end';
                div.innerHTML = `
                    <div class="chat-bubble">${data.pesan.body}
                        <span class="chat-time">${data.pesan.created_at}</span>
                    </div>`;
                chatBody.appendChild(div);
                chatBody.scrollTop = chatBody.scrollHeight;
                inputPesan.value = '';
            }
        });

        inputPesan.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') btnKirim.click();
        });
    }
</script>

</body>
</html>