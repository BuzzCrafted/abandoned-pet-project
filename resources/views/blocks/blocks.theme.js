export default {
    styles: {
        blocks: {
            "core/button": {
                border: { radius: "2px" },
                color: {
                    background: "var(--wp--preset--color--secondary)",
                    text: "var(--wp--preset--color--inverse)",
                },
                "shadow": "var(--wp--preset--shadow--natural)",
                ":hover": {
                    "color": {
                        text: "var(--wp--preset--color--primary)",

                    }
                },
                css: "& { transition: background-color .3s ease, border-color .3s ease, color .3s ease; }",
                variations: {
                    outline: {
                        border: {
                            width: "1px",
                            color: "var(--wp--preset--color--secondary)",
                        },
                        color: {
                            background: "transparent",
                            text: "var(--wp--preset--color--secondary)",
                        },
                        ":hover": {
                            "color": {
                                background: "var(--wp--preset--color--secondary)",
                                text: "var(--wp--preset--color--primary)",
                            },
                            border: {
                                color: "var(--wp--preset--color--primary)",
                            },
                        },
                    },
                },
            },
            "core/list": {
                "css": "list-style-type: disc; list-style-position: outside;"
            }
        },
    },
};