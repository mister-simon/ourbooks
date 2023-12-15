<!DOCTYPE html>
<html lang="en" class="testpage">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>

    @livewireStyles
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="content-grid bg-neutral text-neutral-content">
        <div class="left breakout flex flex-row items-center">
            <a href="/" class="btn btn-ghost">
                <img src="{{ asset('logo.svg') }}" alt="" width="50">
                OurBookstop
            </a>
        </div>
        <nav class="right flex items-center justify-end">
            <ul>
                <li><a href="#">Primary Link</a></li>
            </ul>
        </nav>
    </header>
    <div>
        <main>
            <div class="content-grid prose max-w-none">
                <h1>Heading</h1>
                <h2>First heading</h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsa porro fugiat nihil cumque, odio soluta. Cumque quod non fugiat. Doloremque distinctio, nostrum ipsum incidunt deleniti alias dignissimos cumque quas eveniet.</p>

                <div class="tile-test not-prose">
                    <div>
                        <img src="{{ asset('img/shelf-invite-example.png') }}" alt="" srcset="">
                    </div>
                    <div>
                        <img src="{{ asset('img/books-list-example.png') }}" alt="" srcset="">
                    </div>
                    <div>
                        <img src="{{ asset('img/shelf-search-example.png') }}" alt="" srcset="">
                    </div>
                </div>

                <blockquote class="full-width content-grid bg-neutral text-neutral-content">
                    <p class="breakout">
                        This is a wide blockquote. This is a wide blockquote. This is a wide blockquote. This is a wide blockquote.
                    </p>
                </blockquote>

                <div class="not-prose isolate grid aspect-video grid-cols-4 grid-rows-1 overflow-hidden rounded-box border-8">
                    <div class="col-start-1 col-end-3 row-start-1 row-end-3 overflow-hidden drop-shadow">
                        <img src="{{ asset('img/shelf-invite-example.png') }}" alt="" srcset="" class="mask mask-half-2 mask-parallelogram h-full w-full object-cover">
                    </div>
                    <div class="col-start-1 col-end-5 row-start-1 overflow-hidden">
                        <img src="{{ asset('img/shelf-search-example.png') }}" alt="" srcset="" class="h-full w-full object-cover">
                    </div>
                    <div class="col-start-3 col-end-5 row-start-1 overflow-hidden drop-shadow">
                        <img src="{{ asset('img/books-list-example.png') }}" alt="" srcset="" class="mask-fade-x mask mask-half-1 mask-triangle h-full w-full object-cover object-left">
                    </div>
                </div>

                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsa porro fugiat nihil cumque, odio soluta. Cumque quod non fugiat. Doloremque distinctio, nostrum ipsum incidunt deleniti alias dignissimos cumque quas eveniet.</p>

                <div class="full-width content-grid">
                    <figure class="left breakout not-prose relative mr-2">
                        <img src="{{ asset('img/books-list-example.png') }}" alt="" class="inset-0 h-full w-full object-cover object-left sm:absolute">
                    </figure>

                    <div class="right pl-2">
                        <p>BLEA Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab possimus corrupti iure voluptatum, quia eum laudantium obcaecati ut officia ipsa fugiat provident optio architecto ex neque quibusdam magni molestiae quas.</p>
                        <p>Qui doloribus itaque saepe. Iste odit repudiandae ipsa id molestiae sed harum hic dolores, assumenda amet necessitatibus quod nihil vitae. Quisquam animi rerum porro veritatis mollitia consequuntur blanditiis aut et!</p>
                    </div>
                </div>

                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsa porro fugiat nihil cumque, odio soluta. Cumque quod non fugiat. Doloremque distinctio, nostrum ipsum incidunt deleniti alias dignissimos cumque quas eveniet.</p>

                <blockquote class="bg-neutral text-neutral-content">
                    <p>This is a normal blockquote. This is a normal blockquote. This is a normal blockquote. This is a normal blockquote.</p>
                    <p>This is a normal blockquote. This is a normal blockquote. This is a normal blockquote. This is a normal blockquote.</p>
                </blockquote>

                <div class="full-width content-grid">
                    <div class="left pr-2">
                        <p>BLEA Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab possimus corrupti iure voluptatum, quia eum laudantium obcaecati ut officia ipsa fugiat provident optio architecto ex neque quibusdam magni molestiae quas.</p>
                        <p>Qui doloribus itaque saepe. Iste odit repudiandae ipsa id molestiae sed harum hic dolores, assumenda amet necessitatibus quod nihil vitae. Quisquam animi rerum porro veritatis mollitia consequuntur blanditiis aut et!</p>
                    </div>

                    <figure class="right breakout not-prose relative ml-2">
                        <img src="{{ asset('img/shelf-search-example.png') }}" alt="" class="inset-0 h-full w-full object-cover sm:absolute">
                    </figure>
                </div>

                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsa porro fugiat nihil cumque, odio soluta. Cumque quod non fugiat. Doloremque distinctio, nostrum ipsum incidunt deleniti alias dignissimos cumque quas eveniet.</p>

                <blockquote class="breakout-left bg-neutral text-neutral-content">
                    <p>This is a wide blockquote. This is a wide blockquote. This is a wide blockquote. This is a wide blockquote.</p>
                </blockquote>
                <h2>Heading</h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsa porro fugiat nihil cumque, odio soluta. Cumque quod non fugiat. Doloremque distinctio, nostrum ipsum incidunt deleniti alias dignissimos cumque quas eveniet.</p>

                <blockquote class="full-width content-grid bg-neutral text-neutral-content">
                    <p class="breakout">
                        This is a wide blockquote. This is a wide blockquote. This is a wide blockquote. This is a wide blockquote.
                    </p>
                </blockquote>

                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsa porro fugiat nihil cumque, odio soluta. Cumque quod non fugiat. Doloremque distinctio, nostrum ipsum incidunt deleniti alias dignissimos cumque quas eveniet.</p>

                <blockquote class="breakout-right bg-neutral text-neutral-content">
                    <p>This is a wide blockquote. This is a wide blockquote. This is a wide blockquote. This is a wide blockquote.</p>
                </blockquote>

                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsa porro fugiat nihil cumque, odio soluta. Cumque quod non fugiat. Doloremque distinctio, nostrum ipsum incidunt deleniti alias dignissimos cumque quas eveniet.</p>

                <blockquote class="breakout-left bg-neutral text-neutral-content">
                    <p>This is a wide blockquote. This is a wide blockquote. This is a wide blockquote. This is a wide blockquote.</p>
                </blockquote>
            </div>
        </main>
    </div>
    <footer class="grid place-content-center bg-neutral p-4 text-neutral-content">
        &copy; This is a test footer {{ date('Y') }}
    </footer>
    @livewireScripts
</body>

</html>
