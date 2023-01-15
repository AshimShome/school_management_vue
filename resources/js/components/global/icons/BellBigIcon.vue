<template>
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50"
        viewBox="0 0 63 81">
        <defs>
            <path id="a" d="M22.002 71l-.002.065C22 76.552 26.253 81 31.5 81s9.5-4.448 9.5-9.935L40.998 71H22.002z" />
            <filter id="b" width="273.7%" height="430%" x="-86.8%" y="-165%" filterUnits="objectBoundingBox">
                <feGaussianBlur in="SourceAlpha" result="shadowBlurInner1" stdDeviation="16" />
                <feOffset dy="1" in="shadowBlurInner1" result="shadowOffsetInner1" />
                <feComposite in="shadowOffsetInner1" in2="SourceAlpha" k2="-1" k3="1" operator="arithmetic"
                    result="shadowInnerInner1" />
                <feColorMatrix in="shadowInnerInner1"
                    values="0 0 0 0 0.70440051 0 0 0 0 0.70440051 0 0 0 0 0.70440051 0 0 0 0.5 0" />
            </filter>
            <path id="c"
                d="M62.241 59.192l-8.665-12.668V30.72c0-10.659-7.628-19.543-17.747-21.545V4.308C35.829 1.928 33.89 0 31.5 0c-2.39 0-4.329 1.929-4.329 4.308v4.867C17.052 11.177 9.424 20.062 9.424 30.72v15.805L.76 59.192a4.338 4.338 0 0 0-.251 4.489A4.38 4.38 0 0 0 4.378 66h54.244a4.38 4.38 0 0 0 3.87-2.32 4.339 4.339 0 0 0-.25-4.488z" />
            <filter id="d" width="152.4%" height="150%" x="-26.2%" y="-25%" filterUnits="objectBoundingBox">
                <feGaussianBlur in="SourceAlpha" result="shadowBlurInner1" stdDeviation="16" />
                <feOffset dy="1" in="shadowBlurInner1" result="shadowOffsetInner1" />
                <feComposite in="shadowOffsetInner1" in2="SourceAlpha" k2="-1" k3="1" operator="arithmetic"
                    result="shadowInnerInner1" />
                <feColorMatrix in="shadowInnerInner1"
                    values="0 0 0 0 0.70440051 0 0 0 0 0.70440051 0 0 0 0 0.70440051 0 0 0 0.5 0" />
            </filter>
        </defs>
        <g fill="none" fill-rule="nonzero">
            <g>
                <use fill="#E9EBEE" xlink:href="#a" />
                <use fill="#000" filter="url(#b)" xlink:href="#a" />
            </g>
            <g>
                <use fill="#E9EBEE" xlink:href="#c" />
                <use fill="#000" filter="url(#d)" xlink:href="#c" />
            </g>
        </g>
    </svg>
</template>
