<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <script src="https://soc-core-testing.s3.amazonaws.com/statics/js/socratease-{{ $soc_version }}.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script>

        const allowedCs = {!! json_encode($soc_allowed_content_screens) !!};
        const options = {
            config: { api_host: "{{ $soc_api_host }}" },
            ui: { navbar: { brand_name: "{{ $brand_name }}" } },
            cms: {
                contentPieces: {
                    showSections: ["quiz", "coding_challenge", "qb", "qbQuiz", "assessment"],
                    units: {
                        showScreenByScreen: true,
                        cardActions: {
                            threeDots: ["clone"],
                            onCard: ["preview", "settings", "delete"],
                        },
                        all: {
                            isEnabledExcelImport: true,
                        },
                        quiz: {
                            allowedCs: allowedCs,
                            excludeSettings: ["visible", "accessLevel", "maxAttempts"],
                        },
                    },
                },
            },
        };

        window.addEventListener("load", () => {
            const jsonPayload = JSON.stringify({!! $payload_string !!});
            const hmacPayload = "{{ $hmac_payload }}";
            const clientId = "{{ $soc_client_id }}";
            Socratease.init(clientId, jsonPayload, hmacPayload, options);
        });
    </script>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@3.0.18/src/css/preflight.css" />

    <link rel="stylesheet" href="https://soc-core-testing.s3.amazonaws.com/statics/css/socratease-{{ $soc_version }}.css" />
    <div id="soc-main-app"></div>
</html>
