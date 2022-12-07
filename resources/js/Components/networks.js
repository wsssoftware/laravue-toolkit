/**
 * We use shorter names to reduce the final bundle size
 *
 * Properties:
 * @u = url
 * @t = title
 * @d = description
 * @q = quote
 * @h = hashtags
 * @m = media
 * @tu = twitterUser
 */

const ua = navigator.userAgent.toLowerCase();

export default {
    baidu(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('http://cang.baidu.com/do/add');
        shareUrl.searchParams.append("iu", url);
        shareUrl.searchParams.append("it", title);
        return shareUrl.toString();
    },
    buffer(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://bufferapp.com/add');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("text", title);
        return shareUrl.toString();
    },
    email(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('mailto:');
        let body = url;
        if (description) {
            body += "\n" + description;
        }
        shareUrl.searchParams.append("body", body);
        shareUrl.searchParams.append("subject", title);
        return shareUrl.toString();
    },
    evernote(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.evernote.com/clip.action');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    facebook(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL("https://www.facebook.com/sharer/sharer.php");
        shareUrl.searchParams.append("u", url);
        shareUrl.searchParams.append("title", title);
        if (description) {
            shareUrl.searchParams.append("description", description);
        }
        if (quote) {
            shareUrl.searchParams.append("quote", quote);
        }
        if (hashtags) {
            shareUrl.searchParams.append("hashtag", hashtags);
        }
        return shareUrl.toString();
    },
    flipboard(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://share.flipboard.com/bookmarklet/popout');
        shareUrl.searchParams.append("v", '2');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    hackernews(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://news.ycombinator.com/submitlink');
        shareUrl.searchParams.append("u", url);
        shareUrl.searchParams.append("t", title);
        return shareUrl.toString();
    },
    instapaper(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('http://www.instapaper.com/edit');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        if (description) {
            shareUrl.searchParams.append("description", description);
        }
        return shareUrl.toString();
    },
    line(url, title, description, quote, hashtags, twitterUser, media) {
        let body = title + "\n" + url;
        if (description) {
            body += "\n" + description;
        }
        return 'http://line.me/R/msg/text/?' + encodeURIComponent(body);
    },
    linkedin(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.linkedin.com/sharing/share-offsite/?url=@u');
        shareUrl.searchParams.append("url", url);
        return shareUrl.toString();
    },
    messenger(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('fb-messenger://share/');
        shareUrl.searchParams.append("link", url);
        return shareUrl.toString();
    },
    odnoklassniki(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://connect.ok.ru/dk');
        shareUrl.searchParams.append("st.cmd", 'WidgetSharePreview');
        shareUrl.searchParams.append("st.shareUrl", url);
        shareUrl.searchParams.append("st.comments", title);
        return shareUrl.toString();
    },
    pinterest(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://pinterest.com/pin/create/button/');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("media", media);
        shareUrl.searchParams.append("description", title);
        return shareUrl.toString();
    },
    pocket(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://getpocket.com/save');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    quora(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.quora.com/share');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    reddit(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.reddit.com/submit');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    skype(url, title, description, quote, hashtags, twitterUser, media) {
        let body = title + "\n" + url;
        if (description) {
            body += "\n" + description;
        }
        return 'https://web.skype.com/share?url=' + encodeURIComponent(body);
    },
    sms(url = '', title = '', description = '', quote, hashtags, twitterUser, media) {
        let path = 'sms:?body=@t%0D%0A@u%0D%0A@d'
            .replace(/@u/g, encodeURIComponent(url))
            .replace(/@t/g, encodeURIComponent(title))
            .replace(/@d/g, encodeURIComponent(description))
        if ((ua.indexOf('iphone') > -1 || ua.indexOf('ipad') > -1)) {
            return path.replace(':?', ':&')
        }
        return path;
    },
    stumbleupon(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.stumbleupon.com/submit');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    telegram(url, title, description, quote, hashtags, twitterUser, media) {
        let body = title;
        if (description) {
            body += "\n" + description;
        }
        let shareUrl = new URL('https://t.me/share/url');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("text", body);
        return shareUrl.toString();
    },
    tumblr(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.tumblr.com/share/link');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("name", title);
        if (description) {
            shareUrl.searchParams.append("description", description);
        }
        return shareUrl.toString();
    },
    twitter(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://twitter.com/intent/tweet');
        shareUrl.searchParams.append("text", title);
        shareUrl.searchParams.append("url", url);
        if (hashtags) {
            shareUrl.searchParams.append("hashtags", hashtags);
        }
        if (twitterUser) {
            shareUrl.searchParams.append("via", twitterUser);
        }
        return shareUrl.toString();
    },
    viber(url, title, description, quote, hashtags, twitterUser, media) {
        let body = title + "\n" + url;
        if (description) {
            body += "\n" + description;
        }
        return 'viber://forward?text=' + encodeURIComponent(body);
    },
    vk(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://vk.com/share.php');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        shareUrl.searchParams.append("noparse", 'true');
        if (description) {
            shareUrl.searchParams.append("description", description);
        }
        if (media) {
            shareUrl.searchParams.append("image", media);
        }
        return shareUrl.toString();
    },
    weibo(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('http://service.weibo.com/share/share.php');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        if (media) {
            shareUrl.searchParams.append("pic", media);
        }
        return shareUrl.toString();
    },
    whatsapp(url, title, description, quote, hashtags, twitterUser, media) {
        let body = title;
        if (description) {
            body += "\n" + description;
        }
        let shareUrl = new URL('https://api.whatsapp.com/send?text=@t%0D%0A@u%0D%0A@d');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("text", body);
        return shareUrl.toString();
    },
    wordpress(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://wordpress.com/press-this.php');
        shareUrl.searchParams.append("u", url);
        shareUrl.searchParams.append("t", title);
        if (description) {
            shareUrl.searchParams.append("s", description);
        }
        if (media) {
            shareUrl.searchParams.append("i", media);
        }
        return shareUrl.toString();
    },
    xing(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.xing.com/social/share/spi');
        shareUrl.searchParams.append("op", 'share');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    yammer(url, title, description, quote, hashtags, twitterUser, media) {
        let body = title;
        if (description) {
            body += "\n" + description;
        }
        let shareUrl = new URL('https://www.yammer.com/messages/new');
        shareUrl.searchParams.append("login", 'true');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("status", body);
        return shareUrl.toString();
    }
}
