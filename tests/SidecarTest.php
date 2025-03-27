<?php

use Spatie\Mjml\Exceptions\CouldNotConvertMjml;
use Spatie\Mjml\Mjml;
use Spatie\Mjml\MjmlError;
use Spatie\Mjml\MjmlResult;

it('can render mjml without any options', function () {
    $html = Mjml::new()->sidecar()->toHtml(mjmlSnippet());

    expect($html)->toMatchSnapshot();
})->skipOnLinux();

it('can handle invalid mjml', function () {
    $invalidMjml = '<2mjml></2mjml>';

    Mjml::new()->sidecar()->toHtml($invalidMjml);
})
    ->throws(CouldNotConvertMjml::class, 'Parsing failed. Check your mjml')
    ->skipOnLinux();

it('will render comments by default', function () {
    $mjml = <<<'MJML'
        <mjml>
            <mj-body>
                <!-- my comment -->
            </mj-body >
        </mjml>
        MJML;

    $html = Mjml::new()->sidecar()->toHtml($mjml);

    expect($html)->toContain('<!-- my comment -->');
})->skipOnLinux();

it('can hide comments by default', function () {
    $mjml = <<<'MJML'
        <mjml>
            <mj-body>
                <!-- my comment -->
            </mj-body >
        </mjml>
        MJML;

    $html = Mjml::new()->sidecar()->hideComments()->toHtml($mjml);

    expect($html)->not->toContain('<!-- my comment -->');
})->skipOnLinux();

it('can beautify the rendered html', function () {
    $html = Mjml::new()->sidecar()->beautify()->toHtml(mjmlSnippet());

    expect($html)->toMatchSnapshot();
})->skipOnLinux();

it('can minify the rendered html', function () {
    $html = Mjml::new()->sidecar()->minify()->toHtml(mjmlSnippet());

    expect($html)->toMatchSnapshot();
})->skipOnLinux();

it('can return a direct result from mjml', function () {
    $result = Mjml::new()->sidecar()->minify()->convert(mjmlSnippet());

    expect($result)
        ->toBeInstanceOf(MjmlResult::class)
        ->html()->toBeString()
        ->array()->toBeArray()
        ->errors()->toHaveCount(0)
        ->hasErrors()->toBeFalse();
})->skipOnLinux();

it('can return a direct result from mjml with errors', function () {
    $result = Mjml::new()->sidecar()->convert(mjmlSnippetWithError());

    expect($result)->hasErrors()->toBeTrue();

    expect($result->errors()[0])
        ->toBeInstanceOf(MjmlError::class)
        ->line()->toBe(5)
        ->message()->toBe('Attribute invalid-attribute is illegal')
        ->tagName()->toBe('mj-text');
})->skipOnLinux();

it('can determine if the given mjml can be converted to html', function (string $mjml, bool $expectedResult) {
    expect(Mjml::new()->sidecar()->canConvert($mjml))->toBe($expectedResult);
})->with([
    [mjmlSnippet(), true],
    ['<mjml><mj-body></mj-body></mjml>', true],
    ['<html></html>', false],
    ['</mjml><mjml>', false],
    ['<html><mjml></mjml></html>', false],
])->skipOnLinux();

it('can determine if the given mjml can be converted to html without any errors', function () {
    expect(Mjml::new()->sidecar()->canConvert(mjmlSnippetWithError()))->toBeTrue();
    expect(Mjml::new()->sidecar()->canConvertWithoutErrors(mjmlSnippetWithError()))->toBeFalse();
})->skipOnLinux();

function mjmlSnippet(): string
{
    return <<<'MJML'
        <mjml>
          <mj-body>
            <mj-section>
              <mj-column>
                <mj-text>Hello World</mj-text>
              </mj-column>
            </mj-section>
          </mj-body>
        </mjml>
        MJML;
}

function mjmlSnippetWithError(): string
{
    return <<<'MJML'
        <mjml>
          <mj-body>
            <mj-section>
              <mj-column>
                <mj-text invalid-attribute>Hello World</mj-text>
              </mj-column>
            </mj-section>
          </mj-body>
        </mjml>
        MJML;
}
