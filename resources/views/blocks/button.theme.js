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
                variations: {
                    outline: {
                        border: {
                            width: "1px",
                            color: "var(--wp--preset--color--secondary)",
                        },
                        color: {
                            background: "transparent",
                            text: "var(--wp--preset--color--inverse)",
                        },
                    },
                },
            },
        },
    },
};