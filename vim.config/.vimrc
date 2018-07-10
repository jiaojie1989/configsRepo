map <F3> :NERDTreeToggle<CR>
map <F6> :NERDTreeToggle<CR>

map <F2> :tabn<CR>
map <F1> :tabp<CR>


set nocompatible

set nu

filetype on

colorscheme molokai
set t_Co=256

set background=dark

syntax on
set cursorline

set autoindent
set cindent

set tabstop=4
set shiftwidth=4

set showmatch

set guioptions-=T

set vb t_vb=

set ruler

set hls

set incsearch

set expandtab
set list   "显示tab和行尾空格
set lcs=tab:+-,trail:- "显示tab为+---和行尾空格(只在输入时才显示)

set mouse=a


"设定文件编码类型，彻底解决中文编码问题
let &termencoding=&encoding
set fileencodings=utf-8,gbk,ucs-bom,cp936
"设定调试端口
let g:debuggerPort = 9001

"au FileType php map <F5> :call DebugRun('php')<cr>
"au FileType php imap <F5> <Esc>:call DebugRun('php')<cr>
"au FileType python map <F5> :call DebugRun('python')<cr>
"au FileType python imap <F5> <Esc>:call DebugRun('python')<cr>
"function DebugRun(cmd)
    ":w
    "execute '!' . a:cmd . ' %'
"endfunction
