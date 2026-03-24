@extends('layouts.site', ['title' => 'Training Programs'])

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => 'Courses',
        'title' => 'Training programs',
        'subtitle' => 'Hands-on, career-focused courses designed to equip learners with practical skills for employment, entrepreneurship, and personal development.',
    ])

    @php $imsApply = config('korawigire.ims_application_url'); @endphp

    <div class="-mt-2 border-b border-brand-200/60 bg-gradient-to-r from-brand-50/90 to-white">
        <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-6 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p class="text-sm font-medium text-zinc-600">Questions before you apply? We are happy to help.</p>
            <a href="{{ route('contact') }}" class="inline-flex shrink-0 items-center justify-center rounded-full bg-accent-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-accent-600/20 transition hover:-translate-y-0.5 hover:bg-accent-600">
                Enquire about enrollment
            </a>
        </div>
    </div>

    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
        <p class="max-w-3xl text-zinc-600 leading-relaxed">
            Whether you are starting out or levelling up, our programs combine practical work with real-world application.
            <a href="{{ $imsApply }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-brand-700 underline-offset-2 hover:underline">Apply online</a> for any course, or use the <a href="{{ route('forms.show', 'contact') }}" class="font-semibold text-brand-700 underline-offset-2 hover:underline">contact form</a> / call us for schedules and fees.
        </p>

        <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ([
                [
                    'Graphic Design',
                    'This course introduces students to the world of visual communication. Trainees learn how to create professional designs for print and digital media using modern design tools. Topics include logo design, branding, posters, social media graphics, and basic photo editing. By the end of the course, learners can confidently design materials for businesses, events, and online platforms.',
                ],
                [
                    'Tailoring',
                    'Our tailoring course provides practical skills in garment making and clothing design. Students learn how to take body measurements, cut fabric, sew by hand and machine, and produce different types of clothing. The training also covers fashion basics and finishing techniques, preparing learners to start their own tailoring business or work in the fashion industry.',
                ],
                [
                    'Photography',
                    'This course teaches both the art and technical skills of photography. Learners are trained in camera handling, lighting, composition, and photo editing. The program includes practical sessions in portrait, event, and product photography, enabling students to work professionally or start their own photography services.',
                ],
                [
                    'Carpentry',
                    'The carpentry course focuses on practical woodworking skills. Trainees learn how to use carpentry tools safely, measure and cut materials, and build items such as tables, chairs, doors, and shelves. The course emphasizes precision, creativity, and safety, preparing learners for work in construction or furniture making.',
                ],
                [
                    'Land Survey',
                    'This course introduces students to the basics of land measurement and mapping. Learners are trained to use surveying tools and techniques to measure land boundaries, distances, and levels. The program is suitable for those interested in working in construction, land management, or infrastructure projects.',
                ],
                [
                    'Language Classes',
                    'Our language classes are designed to improve communication skills for work, education, and daily life. We focus on speaking, listening, reading, and writing. The course helps learners gain confidence in using a new language for professional and social interactions.',
                ],
                [
                    'Amategeko y’Umuhanda (Traffic Rules)',
                    'This course teaches road safety and traffic laws. Learners understand road signs, driving rules, and safe road behavior for drivers, riders, and pedestrians. The training prepares students for driving license theory tests and promotes responsible road use.',
                ],
                [
                    'ICT (Information and Communication Technology)',
                    'The ICT course equips learners with essential computer skills. Topics include basic computer use, Microsoft Office, internet usage, email communication, and online safety. This course is ideal for beginners who want to become confident in using digital tools for work and everyday life.',
                ],
            ] as [$title, $body])
                <article class="flex h-full flex-col rounded-3xl border border-brand-200/80 bg-white p-6 shadow-[0_8px_30px_-12px_rgba(0,0,0,0.12)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_40px_-14px_rgba(0,0,0,0.16)]">
                    <h3 class="text-lg font-extrabold leading-snug text-brand-900">{{ $title }}</h3>
                    <p class="mt-3 flex-1 text-sm leading-relaxed text-zinc-600">{{ $body }}</p>
                    <a
                        href="{{ $imsApply }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-6 inline-flex w-fit items-center rounded-full bg-accent-500 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-accent-600/20 transition hover:-translate-y-0.5 hover:bg-accent-600"
                    >Apply now</a>
                </article>
            @endforeach
        </div>
    </div>
@endsection
