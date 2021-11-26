/**
 *
 */
function externalLinkBlank()
{
    let i=0,links = document.querySelectorAll("a[href^=http]");
    for (;i<links.length;i++)
    {
        if (links[i].target != "_blank")
        {
            links[i].target = "_blank";
        }
    }
}
