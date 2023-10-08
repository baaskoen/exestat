<style>
    :root {
        --color-primary: #6767ea;
        --color-secondary: #4949fa;
        --color-grey-1: #efefef;
        --color-grey-2: #e0e0e0;
        --color-grey-3: #c4c4c4;
        --color-text: #4e4f50;
    }

    body {
        background-color: #edf1f3;
        font-family: Arial, sans-serif;
        color: var(--color-text);
    }

    main {
        max-width: 1140px;
        margin: auto;
    }

    .centered {
        margin: auto;
    }

    .w-8 {
        width: 760px;
    }

    .w-3 {
        width: 285px;
    }

    .text-primary {
        color: var(--color-primary);
    }

    .border-bottom {
        border-bottom: thin solid var(--color-grey-1);
    }

    .my-md {
        margin-top: 1rem;
        margin-bottom: 1rem;
    }

    .my-lg {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

    .mt-sm {
        margin-top: 0.5rem;
    }

    .mx-md {
        margin-left: 1rem;
        margin-right: 1rem;
    }

    .mr-sm {
        margin-right: 0.5rem;
    }

    .mb-md {
        margin-bottom: 1rem;
    }

    .mb-lg {
        margin-bottom: 2rem;
    }

    .pa-xs {
        padding: 0.2rem;
    }

    .pa-sm {
        padding: 0.5rem;
    }

    .py-sm {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    .py-md {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .pa-md {
        padding: 1rem;
    }

    .px-md {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .block {
        border-radius: 5px;
        background-color: white;
    }

    .shadow {
        box-shadow: 0 2px 3px var(--color-grey-3);
    }

    .flex {
        display: flex;
        flex-wrap: wrap;
        overflow: hidden;
    }

    .justify-between {
        justify-content: space-between;
    }

    .justify-center {
        justify-content: center;
    }

    .justify-around {
        justify-content: space-around;
    }

    .justify-end {
        justify-content: end;
    }

    .gutter-md {
        gap: 1rem;
    }

    .items-center {
        align-items: center;
    }

    .full-width {
        width: 100%;
    }

    .w-8 {
        width: 760px;
    }

    .text-left {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .relative {
        position: relative;
    }

    .absolute-top-left {
        position: absolute;
        top: 0;
        left: 0;
    }

    .absolute-top-right {
        position: absolute;
        top: 0;
        right: 0;
    }

    button {
        border: none;
        border-radius: 5px;
        cursor: pointer;
        padding: 0.5rem;
        font-weight: bold;
        background-color: var(--color-primary);
        color: white;
    }

    button:hover {
        background-color: var(--color-secondary);
        outline: thin solid var(--color-primary);
    }

    a {
        text-decoration: none;
    }

    a.result {
        color: var(--color-text);
    }

    a.result:hover {
        background-color: var(--color-grey-1);
    }

    .chip {
        font-weight: bold;
        width: 46px;
        text-align: center;
        border-radius: 5px;
        background-color: var(--color-grey-2);
    }

    .chip.method {
        width: 56px;
    }

    .chip.duration {
        width: 96px;
    }

    .text-monospace {
        font-family: monospace;
    }

    .font-bold {
        font-weight: bold;
    }

    .grey-1 {
        background-color: var(--color-grey-1);
    }

    .grey-2 {
        background-color: var(--color-grey-2);
    }

    .grey-3 {
        background-color: var(--color-grey-3);
    }

    .rounded {
        border-radius: 5px;
    }

    table {
        border-collapse: collapse;
    }

    table td, table th {
        font-size: 11pt;
        border: thin solid var(--color-grey-1);
        padding: 0.5rem;
    }
</style>
