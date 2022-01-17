module.exports = {
  '@tags': ['roosky'],
  before(browser) {
    browser.drupalInstall({
      // Relative to web/
      setupFile: 'core/tests/Drupal/TestSite/TestSiteInstallTestScript.php',
    });
  },
  after(browser) {
    browser.drupalUninstall();
  },
  'Test page': (browser) => {
    browser
      .drupalRelativeURL('/test-page')
      .waitForElementVisible('body', 1000)
      .assert.containsText('body', 'Test page text')
      .drupalLogAndEnd({ onlyOnError: false });
  },
  'Hello world': (browser) => {
    browser
      .drupalRelativeURL('/api/hello-world')
      .drupalLogAndEnd({ onlyOnError: false });
  },
};
