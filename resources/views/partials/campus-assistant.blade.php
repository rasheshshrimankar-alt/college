<style>
#campus-ai-launcher{position:fixed;right:24px;bottom:24px;z-index:1050;border:0;border-radius:999px;padding:13px 19px;background:#3157d5;color:#fff;font-weight:700;box-shadow:0 8px 28px #17255444}
#campus-ai-panel{position:fixed;right:24px;bottom:84px;width:min(370px,calc(100vw - 32px));height: min(520px,calc(100vh - 120px));z-index:1051;background:#fff;border:1px solid #e5e7eb;border-radius:18px;box-shadow:0 18px 55px #0f172a33;display:none;overflow:hidden;color:#172033}
#campus-ai-panel.open{display:flex;flex-direction:column}
#campus-ai-head{padding:15px 17px;background:#3157d5;color:#fff;display:flex;justify-content:space-between;align-items:center}
#campus-ai-messages{flex:1;overflow:auto;padding:14px;background:#f7f8fc}
.campus-ai-msg{max-width:88%;padding:10px 12px;border-radius:13px;margin:0 0 10px;white-space:pre-wrap;font-size:13px;line-height:1.5}
.campus-ai-msg.bot{background:#fff;border:1px solid #e5e7eb}
.campus-ai-msg.user{background:#3157d5;color:#fff;margin-left:auto}
#campus-ai-form{display:flex;gap:8px;padding:12px;border-top:1px solid #e5e7eb}
#campus-ai-input{min-width:0;flex:1;border:1px solid #d1d5db;border-radius:10px;padding:10px;font-size:13px}
#campus-ai-send{border:0;border-radius:10px;background:#3157d5;color:#fff;padding:0 15px}
</style>
<button id="campus-ai-launcher" type="button" aria-label="Open Smart Campus Assistant"><i class="bi bi-robot me-1"></i> Campus AI</button>
<section id="campus-ai-panel" aria-label="Smart Campus Assistant" aria-live="polite">
 <header id="campus-ai-head"><div><strong><i class="bi bi-robot me-1"></i> Smart Campus Assistant</strong><div style="font-size:11px;opacity:.85">College help desk</div></div><button id="campus-ai-close" type="button" aria-label="Close" style="background:transparent;color:white;border:0;font-size:22px">&times;</button></header>
 <div id="campus-ai-messages"><div class="campus-ai-msg bot">Hello! I can help with attendance, assignments, exams, fees, timetable, library, placements and notices. What do you need?</div></div>
 <form id="campus-ai-form"><input id="campus-ai-input" maxlength="1200" placeholder="Ask a college question..." autocomplete="off" required><button id="campus-ai-send" type="submit"><i class="bi bi-send-fill"></i></button></form>
</section>
<script>
(()=> {
 const launcher=document.getElementById('campus-ai-launcher'),panel=document.getElementById('campus-ai-panel');
 const close=document.getElementById('campus-ai-close'),form=document.getElementById('campus-ai-form');
 const input=document.getElementById('campus-ai-input'),messages=document.getElementById('campus-ai-messages');
 const token=document.querySelector('meta[name="csrf-token"]')?.content;
 const add=(text,who)=>{const el=document.createElement('div');el.className='campus-ai-msg '+who;el.textContent=text;messages.appendChild(el);messages.scrollTop=messages.scrollHeight;return el;};
 launcher.addEventListener('click',()=>{panel.classList.toggle('open');if(panel.classList.contains('open'))input.focus();});
 close.addEventListener('click',()=>panel.classList.remove('open'));
 form.addEventListener('submit',async e=>{
  e.preventDefault();const message=input.value.trim();if(!message)return;
  add(message,'user');input.value='';input.disabled=true;
  const pending=add('Thinking...','bot');
  try{
   const response=await fetch('/campus-assistant/reply',{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':token||''},body:JSON.stringify({message})});
   const data=await response.json();pending.textContent=data.reply||'Sorry, I could not answer that.';
   if(!response.ok)pending.textContent=data.reply||'Assistant is temporarily unavailable.';
  }catch(error){pending.textContent='Could not connect. Please try again.';}
  finally{input.disabled=false;input.focus();}
 });
})();
</script>
