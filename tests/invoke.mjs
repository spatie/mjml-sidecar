import { handle } from '../lambda/sidecar.js';

let input = '';

for await (const chunk of process.stdin) {
    input += chunk;
}

process.stdout.write(JSON.stringify(await handle(JSON.parse(input))));
